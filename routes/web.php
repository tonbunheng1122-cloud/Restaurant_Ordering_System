<?php
// for login page 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

# Import controller 
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\admin\ReservationController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\SettingController;
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
Route::controller(DashboardController::class)->group(function () {   
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
Route::controller(ProductController::class)->group(function () {

    // LIST + SEARCH
    Route::get('/allproducts', 'index')->name('allproduct.index');

    // CREATE PAGE
    Route::get('/addproducts', 'create')->name('addproduct.index');

    // STORE
    Route::post('/addproducts/store', 'store')->name('addproduct.store');

    // EDIT
    Route::get('/products/edit/{id}', 'edit')->name('product.edit');

    // UPDATE
    Route::put('/products/update/{id}', 'update')->name('product.update');

    // DELETE
    Route::delete('/products/delete/{id}', 'destroy')->name('product.destroy');

    // SHOW (optional)
    Route::get('/products/{id}', 'show')->name('product.show');

});

// Category Group
Route::controller(CategoryController::class)->group(function () {

    Route::get('/allcategories','pageAllcategory')
        ->name('allcategory.index');

    Route::get('/addcategories','pageAddcategory')
        ->name('addcategory.index');

    Route::post('/addcategories/store','store')
        ->name('addcategory.store');

    Route::get('/categories/edit/{id}','edit')
        ->name('category.edit');

    Route::put('/categories/update/{id}','update')
        ->name('category.update');

    Route::delete('/categories/delete/{id}','destroy')
        ->name('category.destroy');
});

Route::controller(MenuController::class)->group(function () {   
    Route::get('/menus', 'pageMenu')->name('menu.index');
});
// ====================================================================
// add + all table
Route::controller(ReservationController::class)->group(function () {   
    // FIX: Match method names to the Controller (index and create)
    Route::get('/alltables', 'index')->name('alltable.index');
    Route::get('/addtables', 'create')->name('addtable.index');
    
    // Form Actions
    Route::post('/reservations', 'store')->name('reservations.store');
    Route::delete('/reservations/{id}', 'destroy')->name('reservations.destroy');
    Route::resource('reservations', ReservationController::class);
    
    Route::prefix('admin')->group(function () {
    Route::get('reservations/search', [ReservationController::class, 'search'])->name('reservations.search');
    Route::resource('reservations', ReservationController::class);
    });
});
// ====================================================================
Route::controller(ReportController::class)->group(function () {   
    Route::get('/reports', 'pageReport')->name('report.index');
});
Route::controller(SettingController::class)->group(function () {   
    Route::get('/settings', 'pageSetting')->name('setting.index');
}); 