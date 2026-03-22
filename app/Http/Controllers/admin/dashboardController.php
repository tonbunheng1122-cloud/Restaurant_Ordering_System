<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // ── Sales Overview — ប្រចាំថ្ងៃ 30 ថ្ងៃចុងក្រោយ ──────────────────────
        $start = Carbon::now()->subDays(29)->startOfDay();
        $end   = Carbon::now()->endOfDay();

        // Build all 30 days with 0 default
        $allDays = collect();
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $allDays[$d->format('d M')] = 0;
        }

        // Fix: group by DATE only, format in PHP not MySQL
        $salesRaw = Order::selectRaw("DATE(created_at) as day_date, SUM(total_amount) as total")
            ->whereBetween('created_at', [$start, $end])
            ->groupByRaw("DATE(created_at)")
            ->orderByRaw("DATE(created_at)")
            ->get()
            ->mapWithKeys(function ($row) {
                $label = Carbon::parse($row->day_date)->format('d M');
                return [$label => (float) $row->total];
            });

        // Merge — keep all 30 days, fill 0 where no orders
        $merged = $allDays->merge($salesRaw);

        $salesLabels = $merged->keys();
        $salesValues = $merged->values()->map(fn($v) => round((float)$v, 2));

        // ── Today vs Yesterday ──────────────────────────────────────────────────
        $todayRevenue     = Order::whereDate('created_at', today())->sum('total_amount');
        $yesterdayRevenue = Order::whereDate('created_at', today()->subDay())->sum('total_amount');
        $revenueChange    = $yesterdayRevenue > 0
            ? round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100, 1)
            : ($todayRevenue > 0 ? 100 : 0);

        $todayOrders     = Order::whereDate('created_at', today())->count();
        $yesterdayOrders = Order::whereDate('created_at', today()->subDay())->count();
        $ordersChange    = $yesterdayOrders > 0
            ? round((($todayOrders - $yesterdayOrders) / $yesterdayOrders) * 100, 1)
            : ($todayOrders > 0 ? 100 : 0);

        return view('admin.itemMenu.dashboard', compact(
            'totalProducts', 'totalCategories', 'totalTables',
            'totalUsers', 'totalRevenue', 'recentProducts',
            'salesLabels', 'salesValues',
            'todayRevenue', 'revenueChange',
            'todayOrders',  'ordersChange'
        ));
    }
}