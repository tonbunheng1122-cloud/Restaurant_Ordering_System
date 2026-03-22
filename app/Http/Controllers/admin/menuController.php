<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;

class MenuController extends Controller
{
    const LOW_STOCK = 2;

    // ── SHOW MENU PAGE ─────────────────────────────────────────────────────────
    public function pageMenu()
    {
        $categories = Category::withCount('products')
            ->get()
            ->map(fn($cat) => [
                'id'    => $cat->id,
                'name'  => $cat->name,
                'count' => $cat->products_count,
            ]);

        $products = Product::with('category')
            ->get()
            ->map(fn($p) => [
                'id'       => $p->id,
                'name'     => $p->name,
                'price'    => (float) $p->price,
                'category' => $p->category->name ?? 'Uncategorized',
                'image'    => $p->images[0] ?? null,
                'qty'      => (int) ($p->qty ?? 0),
            ]);

        $orders = Order::with('items')->latest()->get();

        $lowStockProducts   = Product::where('qty', '<=', self::LOW_STOCK)->where('qty', '>', 0)->get();
        $outOfStockProducts = Product::where('qty', '<=', 0)->get();

        return view('admin.itemMenu.menu', compact(
            'categories', 'products', 'orders',
            'lowStockProducts', 'outOfStockProducts'
        ));
    }

    // ── SAVE ORDER + TELEGRAM ──────────────────────────────────────────────────
    public function storeOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            $order = Order::create([
                'total_amount' => $request->total,
                'status'       => 'pending',
            ]);

            $alertProducts = [];
            $itemLines     = [];

            foreach ($request->cart as $item) {
                // Save order item — name column required
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['id'],
                    'quantity'   => $item['qty'],
                    'price'      => $item['price'],
                    'name'       => $item['name'],
                ]);

                $itemLines[] = "• {$item['name']} x{$item['qty']} = \${$item['price']}";

                // Decrement stock
                $product = Product::find($item['id']);
                if ($product) {
                    $product->qty = max(0, ($product->qty ?? 0) - $item['qty']);
                    $product->save();

                    if ($product->qty <= self::LOW_STOCK) {
                        $alertProducts[] = $product;
                    }
                }
            }

            DB::commit();

            // ── Telegram: New Order notification ──
            $this->sendTelegram(implode("\n", [
                "🛎 *New Order — FastBite*",
                "━━━━━━━━━━━━━━━━━━━━",
                "*Order ID:* #" . $order->id,
                "*Status:* 🟡 Pending",
                "*Items:*",
                implode("\n", $itemLines),
                "━━━━━━━━━━━━━━━━━━━━",
                "*Total: \$" . number_format($request->total, 2) . "*",
            ]));

            // ── Telegram: Stock alerts ──
            foreach ($alertProducts as $product) {
                $this->sendStockAlert($product);
            }

            return response()->json([
                'message'      => 'Order saved successfully',
                'order_id'     => $order->id,
                'stock_alerts' => collect($alertProducts)->map(fn($p) => [
                    'name' => $p->name,
                    'qty'  => $p->qty,
                ]),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ── UPDATE STATUS + TELEGRAM ───────────────────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,confirmed,processing,completed,cancelled',
            ]);

            $order = Order::findOrFail($id);
            $old   = $order->status;
            $order->update(['status' => $request->status]);

            // ── Telegram: Status changed notification ──
            $emoji = match ($request->status) {
                'confirmed'  => '🔵',
                'processing' => '🟣',
                'completed'  => '🟢',
                'cancelled'  => '🔴',
                default      => '🟡',
            };

            $this->sendTelegram(implode("\n", [
                "{$emoji} *Order Status Updated — FastBite*",
                "━━━━━━━━━━━━━━━━━━━━",
                "*Order ID:* #" . $order->id,
                "*Previous:* " . ucfirst($old),
                "*New Status:* " . ucfirst($request->status),
                "━━━━━━━━━━━━━━━━━━━━",
                "_Updated by admin._",
            ]));

            return response()->json([
                'message' => 'Status updated',
                'status'  => $order->status,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Invalid status value.'], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ── DELETE ORDER + TELEGRAM ────────────────────────────────────────────────
    public function destroyOrder($id)
    {
        try {
            $order = Order::with('items')->findOrFail($id);

            $itemLines = $order->items->map(fn($i) => "• {$i->name} x{$i->quantity}")->toArray();
            $total     = $order->total_amount;
            $status    = $order->status;

            $order->items()->delete();
            $order->delete();

            $this->sendTelegram(implode("\n", [
                "🗑 *Order Deleted — FastBite*",
                "━━━━━━━━━━━━━━━━━━━━",
                "*Order ID:* #" . $id,
                "*Was Status:* " . ucfirst($status),
                "*Items:*",
                implode("\n", $itemLines ?: ["• (no items)"]),
                "━━━━━━━━━━━━━━━━━━━━",
                "*Total was: \$" . number_format($total, 2) . "*",
                "_Deleted by admin._",
            ]));

            return response()->json(['message' => 'Order deleted']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ── TELEGRAM: STOCK ALERT ──────────────────────────────────────────────────
    private function sendStockAlert(Product $product): void
    {
        $emoji   = $product->qty <= 0 ? '🚫' : '⚠️';
        $status  = $product->qty <= 0 ? '🚫 OUT OF STOCK' : '⚠️ LOW STOCK';

        $this->sendTelegram(implode("\n", [
            "{$emoji} *FastBite Stock Alert*",
            "━━━━━━━━━━━━━━━━━━━━",
            "*Product:* {$product->name}",
            "*Status:* {$status}",
            "*Remaining:* {$product->qty} units",
            "━━━━━━━━━━━━━━━━━━━━",
            "_Please restock immediately._",
        ]));
    }

    // ── TELEGRAM: SEND MESSAGE ─────────────────────────────────────────────────
    private function sendTelegram(string $message): void
    {
        $botToken = Setting::get('telegram_bot_token') ?? env('TELEGRAM_BOT_TOKEN');
        $chatId   = Setting::get('telegram_chat_id')   ?? env('TELEGRAM_CHAT_ID');

        if (!$botToken || !$chatId) {
            Log::warning('Telegram not configured — skipping alert.');
            return;
        }

        try {
            $response = Http::timeout(5)->post(
                "https://api.telegram.org/bot{$botToken}/sendMessage",
                [
                    'chat_id'    => $chatId,
                    'text'       => $message,
                    'parse_mode' => 'Markdown',
                ]
            );

            if (!$response->successful()) {
                Log::warning('Telegram send failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::warning('Telegram exception: ' . $e->getMessage());
        }
    }
}