<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;

class ReportController extends Controller
{
    public function pageReport()
    {
        $products     = Product::with('category')->get();
        $categories   = Category::withCount('products')->get();
        $orders       = Order::orderBy('created_at', 'desc')->get();
        $orderItems   = OrderItem::with('product')->get();
        $reservations = Reservation::orderBy('created_at', 'desc')->get();

        return view('admin.itemMenu.report', compact(
            'products', 'categories', 'orders', 'orderItems', 'reservations'
        ));
    }

    // ===================== EXCEL EXPORT =====================
    public function exportExcel(Request $request)
    {
        $type = $request->get('type', 'all');

        // Build CSV content
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
                $headers = ['ID', 'Status', 'Total Amount', 'Date'];
                foreach (Order::orderBy('created_at', 'desc')->get() as $o) {
                    $rows[] = [$o->id, $o->status, $o->total_amount, $o->created_at->format('d M Y h:i A')];
                }
                break;

            case 'products':
                $headers = ['ID', 'Name', 'Category', 'Price', 'Qty'];
                foreach (Product::with('category')->get() as $p) {
                    $rows[] = [$p->id, $p->name, $p->category?->name ?? 'N/A', $p->price, $p->qty ?? 'N/A'];
                }
                break;

            case 'categories':
                $headers = ['ID', 'Name', 'Total Products', 'Created At'];
                foreach (Category::withCount('products')->get() as $c) {
                    $rows[] = [$c->id, $c->name, $c->products_count, $c->created_at->format('d M Y')];
                }
                break;

            default: // all
                $headers = ['Section', 'ID', 'Col1', 'Col2', 'Col3', 'Col4'];
                foreach (Reservation::all() as $r) {
                    $rows[] = ['Reservation', $r->id, $r->full_name, $r->phone_number, $r->date . ' ' . $r->time, 'Table ' . $r->table_id];
                }
                foreach (Order::all() as $o) {
                    $rows[] = ['Order', $o->id, $o->status, '$' . number_format($o->total_amount, 2), $o->created_at->format('d M Y'), ''];
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

    // ===================== PDF EXPORT =====================
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

        // Use wkhtmltopdf via Symfony Process if available, otherwise return HTML as download
        $filename = 'fastbite-report-' . $type . '-' . now()->format('Ymd-His') . '.html';

        return response($html, 200, [
            'Content-Type'        => 'text/html',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}




// Test API respose json
// return response()->json([
//     'products' => $products, 
//     'categories' => $categories,
//     'orders' => $orders,
//     'reservations' => $reservations
// ]);
        
        