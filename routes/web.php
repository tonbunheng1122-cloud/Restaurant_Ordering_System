<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Layouts\UserwebController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\admin\ReservationController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\ProfileController;   // ← NEW
use App\Http\Controllers\admin\LogoutController;
use App\Http\Controllers\admin\UserController;

// ================================================================================
// TEST REDIS RUN OR NOT
// ================================================================================
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
Route::get('/test-redis', function () {
    try {
        Redis::set('fastbite_status', 'Redis is working!');
        $redis_status = Redis::get('fastbite_status');

        Cache::put('cache_test', 'Cache is also working!', 10);
        $cache_status = Cache::get('cache_test');

        return response()->json([
            'redis_direct' => $redis_status,
            'cache_driver' => $cache_status,
            'message' => 'Redis connection 100% successful!'
        ]);
    } catch (\Exception $e) {
        return "Error: Could not connect to Redis! " . $e->getMessage();
    }
});

// ================================================================================
// PUBLIC ROUTES
// ================================================================================

Route::get('/', [UserwebController::class, 'pages'])->name('userweb.index');

Route::get('/login',   [LoginController::class, 'showLogin'])->name('login');
Route::post('/login',  [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// ================================================================================
// PROTECTED ROUTES — all logged-in users
// ================================================================================

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboards', [DashboardController::class, 'pageDashboard'])->name('dashboard.index');

    // Products
    Route::controller(ProductController::class)->group(function () {
        Route::get('/allproducts',             'index') ->name('allproduct.index');
        Route::get('/addproducts',             'create')->name('addproduct.index');
        Route::post('/addproducts/store',      'store') ->name('addproduct.store');
        Route::get('/products/edit/{id}',      'edit')  ->name('product.edit');
        Route::put('/products/update/{id}',    'update')->name('product.update');
        Route::delete('/products/delete/{id}', 'destroy')->name('product.destroy');
        Route::get('/products/{id}',           'show')  ->name('product.show');
    });

    // Categories
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/allcategories',             'pageAllcategory')->name('allcategory.index');
        Route::get('/addcategories',             'pageAddcategory')->name('addcategory.index');
        Route::post('/addcategories/store',      'store')          ->name('addcategory.store');
        Route::get('/categories/edit/{id}',      'edit')           ->name('category.edit');
        Route::put('/categories/update/{id}',    'update')         ->name('category.update');
        Route::delete('/categories/delete/{id}', 'destroy')        ->name('category.destroy');
    });

    // Menu & Orders
    Route::get('/menu',                    [MenuController::class, 'pageMenu'])    ->name('menu.index');
    Route::post('/order/store',            [MenuController::class, 'storeOrder'])  ->name('order.store');
    Route::post('/order/{id}/status',      [MenuController::class, 'updateStatus'])->name('order.status');
    Route::delete('/order/{id}',           [MenuController::class, 'destroyOrder'])->name('order.destroy');

    // Reservations / Tables
    Route::controller(ReservationController::class)->group(function () {
        Route::get('/alltables',           'index') ->name('alltable.index');
        Route::get('/reservations',        'index') ->name('reservations.index');
        Route::get('/addtables',           'create')->name('addtable.index');
        Route::post('/reservations',       'store') ->name('reservations.store');
        Route::delete('/reservations/{id}','destroy')->name('reservations.destroy');
    });

    Route::prefix('admin')->group(function () {
        Route::get('reservations/search', [ReservationController::class, 'search'])->name('reservations.search');
        Route::resource('reservations', ReservationController::class)
            ->except(['index', 'create', 'store', 'destroy']);
    });

    // Reports
    Route::get('/reports',              [ReportController::class, 'pageReport']) ->name('report.index');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('report.excel');
    Route::get('/reports/export/pdf',   [ReportController::class, 'exportPdf'])  ->name('report.pdf');

    // ── Settings (General) ───────────────────────────────────────────────────────
    Route::get('/settings',        [SettingController::class, 'pageSetting'])->name('setting.index');
    Route::post('/settings/save',  [SettingController::class, 'save'])        ->name('setting.save');
    Route::post('/settings/image', [SettingController::class, 'deleteImage']) ->name('setting.deleteImage');

    // Website content CRUD
    Route::post('/setting/dish',               [SettingController::class, 'storeDish'])    ->name('setting.dish.store');
    Route::post('/setting/dish/{id}/update',   [SettingController::class, 'updateDish'])   ->name('setting.dish.update');
    Route::post('/setting/dish/{id}/delete',   [SettingController::class, 'destroyDish'])  ->name('setting.dish.destroy');
    Route::post('/setting/ticker',             [SettingController::class, 'storeTicker'])  ->name('setting.ticker.store');
    Route::post('/setting/ticker/{id}/delete', [SettingController::class, 'destroyTicker'])->name('setting.ticker.destroy');
    Route::post('/setting/feature',            [SettingController::class, 'saveFeature'])  ->name('setting.feature.save');

    // ── Profile (inside Settings page — Profile tab) ─────────────────────────────
    Route::post('/settings/profile/info',     [ProfileController::class, 'updateInfo'])    ->name('profile.updateInfo');
    Route::post('/settings/profile/avatar',   [ProfileController::class, 'updateAvatar'])  ->name('profile.updateAvatar');
    Route::post('/settings/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/settings/profile',        [ProfileController::class, 'destroy'])       ->name('profile.destroy');

    // ============================================================================
    // ADMIN-ONLY ROUTES
    // ============================================================================

    Route::middleware(['admin'])->group(function () {
        Route::get('/users',           [UserController::class, 'index'])  ->name('user.index');
        Route::get('/users/create',    [UserController::class, 'create']) ->name('user.create');
        Route::post('/users',          [UserController::class, 'store'])  ->name('user.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])   ->name('user.edit');
        Route::put('/users/{id}',      [UserController::class, 'update']) ->name('user.update');
        Route::delete('/users/{id}',   [UserController::class, 'destroy'])->name('user.destroy');
    });

});