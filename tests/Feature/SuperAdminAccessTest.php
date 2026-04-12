<?php

use App\Models\Category;
use App\Models\Logins;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reservation;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('creates the default admin account through the database seeder', function () {
    $this->seed(DatabaseSeeder::class);

    $admin = Logins::where('username', 'admin')->first();

    expect($admin)->not->toBeNull();
    expect($admin->hasAdminAccess())->toBeTrue();
    expect($admin->isSuperAdmin())->toBeTrue();
    expect(Hash::check('admin123', $admin->password))->toBeTrue();
});

it('lets the super admin see all orders in the menu page', function () {
    $superAdmin = Logins::create([
        'username' => 'admin',
        'password' => Hash::make('admin123'),
        'role' => 'Admin',
    ]);

    $staff = Logins::create([
        'username' => 'staff',
        'password' => Hash::make('secret123'),
        'role' => 'User',
    ]);

    $category = Category::create([
        'name' => 'Meals',
    ]);

    Product::create([
        'category_id' => $category->id,
        'name' => 'Rice Bowl',
        'qty' => 5,
        'price' => 4.50,
        'cost' => 2.00,
        'count' => 0,
        'description' => 'Test meal',
        'images' => ['meal.jpg'],
    ]);

    $guestOrder = Order::create([
        'total_amount' => 12.00,
        'status' => 'pending',
        'user_id' => null,
    ]);

    $staffOrder = Order::create([
        'total_amount' => 8.00,
        'status' => 'pending',
        'user_id' => $staff->id,
    ]);

    $response = $this->actingAs($superAdmin)->get('/menu');

    $response->assertOk();

    $orderIds = $response->viewData('orders')->pluck('id');

    expect($orderIds)->toContain($guestOrder->id);
    expect($orderIds)->toContain($staffOrder->id);
});

it('lets the super admin see all reservations', function () {
    $superAdmin = Logins::create([
        'username' => 'admin',
        'password' => Hash::make('admin123'),
        'role' => 'Admin',
    ]);

    $userA = Logins::create([
        'username' => 'user-a',
        'password' => Hash::make('secret123'),
        'role' => 'User',
    ]);

    $userB = Logins::create([
        'username' => 'user-b',
        'password' => Hash::make('secret123'),
        'role' => 'User',
    ]);

    $reservationA = Reservation::create([
        'full_name' => 'User A',
        'phone_number' => '111111',
        'date' => '2026-04-06',
        'time' => '18:00',
        'table_id' => 'A1',
        'user_id' => $userA->id,
    ]);

    $reservationB = Reservation::create([
        'full_name' => 'User B',
        'phone_number' => '222222',
        'date' => '2026-04-06',
        'time' => '19:00',
        'table_id' => 'B2',
        'user_id' => $userB->id,
    ]);

    $response = $this->actingAs($superAdmin)->get('/reservations');

    $response->assertOk();

    $reservationIds = collect($response->viewData('reservations')->items())->pluck('id');

    expect($reservationIds)->toContain($reservationA->id);
    expect($reservationIds)->toContain($reservationB->id);
});
