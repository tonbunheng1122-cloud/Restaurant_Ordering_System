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
        // Load all data needed for the report
        $products = Product::with('category')->get();
        $categories = Category::withCount('products')->get();
        $orders = Order::orderBy('created_at', 'desc')->get();
        $orderItems = OrderItem::with('product')->get();
        $reservations = Reservation::orderBy('created_at', 'desc')->get();

        // Pass all to view
        return view('admin.itemMenu.report', compact(
            'products', 'categories', 'orders', 'orderItems', 'reservations'
        ));
    }
}
// Test API respose json
// return response()->json([
//     'products' => $products, 
//     'categories' => $categories,
//     'orders' => $orders,
//     'reservations' => $reservations
// ]);
        
        