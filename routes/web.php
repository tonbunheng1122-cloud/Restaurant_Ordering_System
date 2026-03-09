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



// ================================================================================
// --- AUTHENTICATION ROUTES (Login/Register/Logout) ---

// ================================================================================

// testing for website

Route::get('/', [UserwebController::class, 'pages'])->name('userweb.index');
// ================================================================================

// Redirect root to login
//Route::get('/', function () {
//    return redirect()->route('login');
//});

// Login
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register
Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

// Logout
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ================================================================================
// --- ADMIN ROUTES (Protected by Auth middleware) ---
// ================================================================================

Route::middleware(['auth'])->group(function () {

    // --- DASHBOARD ---
    Route::get('/dashboards', [DashboardController::class, 'pageDashboard'])->name('dashboard.index');

    // --- PRODUCT MANAGEMENT ---
    Route::controller(ProductController::class)->group(function () {
        Route::get('/allproducts', 'index')->name('allproduct.index');
        Route::get('/addproducts', 'create')->name('addproduct.index');
        Route::post('/addproducts/store', 'store')->name('addproduct.store');
        Route::get('/products/edit/{id}', 'edit')->name('product.edit');
        Route::put('/products/update/{id}', 'update')->name('product.update');
        Route::delete('/products/delete/{id}', 'destroy')->name('product.destroy');
        Route::get('/products/{id}', 'show')->name('product.show');
    });

    // --- CATEGORY MANAGEMENT ---
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/allcategories', 'pageAllcategory')->name('allcategory.index');
        Route::get('/addcategories', 'pageAddcategory')->name('addcategory.index');
        Route::post('/addcategories/store', 'store')->name('addcategory.store');
        Route::get('/categories/edit/{id}', 'edit')->name('category.edit');
        Route::put('/categories/update/{id}', 'update')->name('category.update');
        Route::delete('/categories/delete/{id}', 'destroy')->name('category.destroy');
    });

    // --- MENU ---
    Route::get('/menus', [MenuController::class, 'pageMenu'])->name('menu.index');

// --- RESERVATION / TABLE MANAGEMENT ---
Route::controller(ReservationController::class)->group(function () {   
    // បង្កើត Route ឱ្យចំឈ្មោះដែល Laravel កំពុងទាមទារ (reservations.index)
    Route::get('/alltables', 'index')->name('alltable.index'); // សម្រាប់ link ក្នុង menu
    Route::get('/reservations', 'index')->name('reservations.index'); // បន្ថែមនេះដើម្បីបំបាត់ Error
    
    Route::get('/addtables', 'create')->name('addtable.index');
    Route::post('/reservations', 'store')->name('reservations.store');
    Route::delete('/reservations/{id}', 'destroy')->name('reservations.destroy');
});

// Resource & Search (ដាក់នៅក្រៅ Controller Group ដើម្បីកុំឱ្យជាន់គ្នា)
Route::prefix('admin')->group(function () {
    Route::get('reservations/search', [ReservationController::class, 'search'])->name('reservations.search');
    // បើអ្នកប្រើ resource វានឹងបង្កើត index, create, store... ឱ្យដោយស្វ័យប្រវត្តិ
    Route::resource('reservations', ReservationController::class)->except(['index', 'create', 'store', 'destroy']);
});

    // --- REPORTS & SETTINGS ---
    Route::get('/reports', [ReportController::class, 'pageReport'])->name('report.index');
    Route::get('/settings', [SettingController::class, 'pageSetting'])->name('setting.index');

});