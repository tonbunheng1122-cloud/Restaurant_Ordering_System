<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function pageDashboard()
    {
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalTables     = Reservation::select('table_id')->distinct()->count('table_id');
        $totalUsers      = DB::table('logins')->count();
        $totalRevenue    = Order::sum('total_amount');

        $recentProducts  = Product::with('category')->latest()->take(5)->get();

        // Sales overview — total revenue grouped by month (last 6 months)
        $salesData = Order::selectRaw("DATE_FORMAT(created_at, '%b') as month, SUM(total_amount) as total")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupByRaw("DATE_FORMAT(created_at, '%b'), MONTH(created_at)")
            ->orderByRaw("MONTH(created_at)")
            ->pluck('total', 'month');

        $salesLabels = $salesData->keys();
        $salesValues = $salesData->values();

        return view('admin.itemMenu.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalTables',
            'totalUsers',
            'totalRevenue',
            'recentProducts',
            'salesLabels',
            'salesValues'
        ));
    }
}