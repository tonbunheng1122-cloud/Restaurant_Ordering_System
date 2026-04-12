<?php

use App\Models\Logins;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('returns all order notifications for the super admin', function () {
    $admin = Logins::create([
        'username' => 'admin',
        'password' => Hash::make('admin123'),
        'role' => 'Admin',
    ]);

    $user = Logins::create([
        'username' => 'cashier',
        'password' => Hash::make('secret123'),
        'role' => 'User',
    ]);

    $guestOrder = Order::create([
        'total_amount' => 10.50,
        'status' => 'pending',
        'user_id' => null,
    ]);

    $userOrder = Order::create([
        'total_amount' => 18.00,
        'status' => 'confirmed',
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($admin)->getJson(route('notifications.orders'));

    $response->assertOk();

    $notifications = collect($response->json('notifications'));

    expect($notifications->pluck('id'))->toContain($guestOrder->id);
    expect($notifications->pluck('id'))->toContain($userOrder->id);
});

it('returns only own order notifications for a normal user', function () {
    $user = Logins::create([
        'username' => 'staff-user',
        'password' => Hash::make('secret123'),
        'role' => 'User',
    ]);

    $otherUser = Logins::create([
        'username' => 'other-user',
        'password' => Hash::make('secret123'),
        'role' => 'User',
    ]);

    $ownOrder = Order::create([
        'total_amount' => 9.50,
        'status' => 'pending',
        'user_id' => $user->id,
    ]);

    Order::create([
        'total_amount' => 21.00,
        'status' => 'completed',
        'user_id' => $otherUser->id,
    ]);

    Order::create([
        'total_amount' => 7.00,
        'status' => 'pending',
        'user_id' => null,
    ]);

    $response = $this->actingAs($user)->getJson(route('notifications.orders'));

    $response->assertOk();

    $notifications = collect($response->json('notifications'));

    expect($notifications)->toHaveCount(1);
    expect($notifications->first()['id'])->toBe($ownOrder->id);
    expect($notifications->first()['message'])->toBe('Your order total is $9.50');
});
