<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


# Import controller 
use App\Http\Controllers\admin\dashboardController;
use App\Http\Controllers\admin\productController;
use App\Http\Controllers\admin\categoryController;
use App\Http\Controllers\admin\menuController;
use App\Http\Controllers\admin\tableController;
use App\Http\Controllers\admin\reportController;
use App\Http\Controllers\admin\settingController;
// ================================================================================
// --- LOGIN ROUTES ---
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboards');
    }

    return back()->withErrors(['username' => 'The provided credentials do not match our records.']);
});
// --- DASHBOARD ---
Route::controller(dashboardController::class)->group(function () {   
    Route::get('/dashboards', 'pageDashboard')->name('dashboard.index');
});

// --- REGISTER ROUTES ---
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'username' => 'required|string|unique:users|max:255',
        'password' => 'required|string|min:6|confirmed', // looks for password_confirmation
    ]);

    User::create([
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'role' => 'Admin',
    ]);

    return redirect()->route('login')->with('success', 'Account created! Please login.');
});

// --- LOGOUT ---
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');



// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});
// ================================================================================
// add + all product
Route::controller(productController::class)->group(function () {   
    Route::get('/addproducts', 'pageAddproduct')->name('addproduct.index');
    Route::get('/allproducts', 'pageAllproduct')->name('allproduct.index');
});
// add + all category
Route::controller(categoryController::class)->group(function () {   
    Route::get('/allcategories', 'pageAllcategory')->name('allcategory.index');
    Route::get('/addcategories', 'pageAddcategory')->name('addcategory.index');   
});

Route::controller(menuController::class)->group(function () {   
    Route::get('/menus', 'pageMenu')->name('menu.index');
});
// add + all table
Route::controller(tableController::class)->group(function () {   
    Route::get('/alltables', 'pageAlltable')->name('alltable.index');
    Route::get('/addtables', 'pageAddtable')->name('addtable.index');
});

Route::controller(reportController::class)->group(function () {   
    Route::get('/reports', 'pageReport')->name('report.index');
});
Route::controller(settingController::class)->group(function () {   
    Route::get('/settings', 'pageSetting')->name('setting.index');
});