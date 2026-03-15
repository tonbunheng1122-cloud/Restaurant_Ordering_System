<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;

class MenuController extends Controller
{
    // ==============================
    // Show Menu Page
    // ==============================
    public function pageMenu()
    {
        $categories = Category::withCount('products')
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'count' => $cat->products_count . ' Items'
                ];
            });

        $products = Product::with('category')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => (float) $p->price,
                    'category' => $p->category->name ?? 'Uncategorized',
                    'image' => $p->images[0] ?? null
                ];
            });

        $orders = Order::with('items')->latest()->get();

        return view('admin.itemMenu.menu', compact(
            'categories',
            'products',
            'orders'   // ✅ pass orders to blade
        ));
    }

    // ==============================
    // Save Order
    // ==============================
    public function storeOrder(Request $request)
    {
        try {

            DB::beginTransaction();

            // Create Order
            $order = Order::create([
                'total_amount' => $request->total,
                'status' => 'pending'
            ]);

            // Save Order Items
            foreach ($request->cart as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Order saved successfully',
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}