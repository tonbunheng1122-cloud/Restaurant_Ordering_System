<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function pageReport()
    {
        $products     = Product::with('category')->get();
        $categories   = Category::withCount('products')->get();
        $orders       = Order::with('items.product')->orderBy('created_at', 'desc')->get();
        $orderItems   = OrderItem::with('product')->get();
        $reservations = Reservation::orderBy('created_at', 'desc')->get();

        // Pre-calculate sales stats here (avoids Collection method errors in blade)
        $completedOrders = $orders->where('status', 'completed');

        $dailySalesTotal = $completedOrders
            ->filter(fn($o) => Carbon::parse($o->created_at)->isToday())
            ->sum('total_amount');

        $monthlySalesTotal = $completedOrders
            ->filter(fn($o) => Carbon::parse($o->created_at)->month === now()->month
                            && Carbon::parse($o->created_at)->year  === now()->year)
            ->sum('total_amount');

        $grandTotal = $completedOrders->sum('total_amount');

        $todayOrders = $completedOrders
            ->filter(fn($o) => Carbon::parse($o->created_at)->isToday());

        $todayTotal = $todayOrders->sum('total_amount');
        $todayCount = $todayOrders->count();

        $monthlyCount = $completedOrders
            ->filter(fn($o) => Carbon::parse($o->created_at)->month === now()->month
                            && Carbon::parse($o->created_at)->year  === now()->year)
            ->count();

        // Group sales by date for the Sales tab
        $salesByDate = $completedOrders
            ->groupBy(fn($o) => Carbon::parse($o->created_at)->format('Y-m-d'))
            ->sortKeysDesc();

        return view('Admin.Reports.report', compact(
            'products',
            'categories',
            'orders',
            'orderItems',
            'reservations',
            'completedOrders',
            'dailySalesTotal',
            'monthlySalesTotal',
            'grandTotal',
            'todayTotal',
            'todayCount',
            'monthlyCount',
            'salesByDate',
        ));
    }


    public function exportExcel(Request $request)
    {
        $type = $request->get('type', 'all');

        $rows    = [];
        $headers = [];

        switch ($type) {
            case 'reservations':
                $headers = ['ID', 'Full Name', 'Phone', 'Date', 'Time', 'Table'];
                foreach (Reservation::orderBy('created_at', 'desc')->get() as $r) {
                    $rows[] = [$r->id, $r->full_name, $r->phone_number, $r->date, $r->time, $r->table_id];
                }
                break;

            case 'orders':
                $headers = ['ID', 'Items', 'Status', 'Total Amount', 'Date'];
                foreach (Order::with('items.product')->orderBy('created_at', 'desc')->get() as $o) {
                    $itemsList = $o->items->map(fn($i) => ($i->name ?? $i->product?->name ?? 'Unknown') . ' x' . $i->quantity)->join(', ');
                    $rows[] = [$o->id, $itemsList ?: '—', $o->status, $o->total_amount, $o->created_at->format('d M Y h:i A')];
                }
                break;

            case 'products':
                $headers = ['ID', 'Name', 'Category', 'Price', 'Cost', 'Qty'];
                foreach (Product::with('category')->get() as $p) {
                    $rows[] = [$p->id, $p->name, $p->category?->name ?? 'N/A', $p->price, $p->cost ?? 0, $p->qty ?? 'N/A'];
                }
                break;

            case 'categories':
                $headers = ['ID', 'Name', 'Code', 'Total Products', 'Created At'];
                foreach (Category::withCount('products')->get() as $c) {
                    $rows[] = [$c->id, $c->name, $c->code ?? '—', $c->products_count, $c->created_at->format('d M Y')];
                }
                break;

            case 'sales':
                $headers = ['Date', 'Order ID', 'Items', 'Time', 'Amount'];
                $completed = Order::with('items.product')->where('status', 'completed')->orderBy('created_at', 'desc')->get();
                foreach ($completed as $o) {
                    $itemsList = $o->items->map(fn($i) => ($i->name ?? $i->product?->name ?? 'Unknown') . ' x' . $i->quantity)->join(', ');
                    $rows[] = [
                        Carbon::parse($o->created_at)->format('d M Y'),
                        '#' . $o->id,
                        $itemsList ?: '—',
                        Carbon::parse($o->created_at)->format('h:i A'),
                        number_format($o->total_amount ?? 0, 2),
                    ];
                }
                $rows[] = ['', '', '', 'GRAND TOTAL', number_format($completed->sum('total_amount'), 2)];
                break;

            default:
                $headers = ['Section', 'ID', 'Col1', 'Col2', 'Col3', 'Col4'];
                foreach (Reservation::all() as $r) {
                    $rows[] = ['Reservation', $r->id, $r->full_name, $r->phone_number, $r->date . ' ' . $r->time, 'Table ' . $r->table_id];
                }
                foreach (Order::with('items.product')->get() as $o) {
                    $itemsList = $o->items->map(fn($i) => ($i->name ?? $i->product?->name ?? 'Unknown') . ' x' . $i->quantity)->join(', ');
                    $rows[] = ['Order', $o->id, $itemsList ?: '—', $o->status, '$' . number_format($o->total_amount, 2), $o->created_at->format('d M Y')];
                }
                foreach (Product::with('category')->get() as $p) {
                    $rows[] = ['Product', $p->id, $p->name, $p->category?->name ?? 'N/A', '$' . number_format($p->price, 2), $p->qty ?? 'N/A'];
                }
                foreach (Category::withCount('products')->get() as $c) {
                    $rows[] = ['Category', $c->id, $c->name, $c->products_count . ' items', $c->created_at->format('d M Y'), ''];
                }
                break;
        }

        $filename = 'fastbite-report-' . $type . '-' . now()->format('Ymd-His') . '.csv';

        $output = fopen('php://temp', 'r+');
        fputcsv($output, $headers);
        foreach ($rows as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }


    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'all');

        $data = [
            'type'         => $type,
            'generatedAt'  => now()->format('d M Y, h:i A'),
            'reservations' => in_array($type, ['all', 'reservations']) ? Reservation::orderBy('created_at', 'desc')->get() : collect(),
            'orders'       => in_array($type, ['all', 'orders'])       ? Order::orderBy('created_at', 'desc')->get()       : collect(),
            'products'     => in_array($type, ['all', 'products'])     ? Product::with('category')->get()                  : collect(),
            'categories'   => in_array($type, ['all', 'categories'])   ? Category::withCount('products')->get()            : collect(),
        ];

        $html = view('components.report_pdf', $data)->render();

        $filename = 'fastbite-report-' . $type . '-' . now()->format('Ymd-His') . '.html';

        return response($html, 200, [
            'Content-Type'        => 'text/html',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}