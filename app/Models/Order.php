<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Order extends Model
{
    protected $fillable = [
        'table_number',
        'total_amount',
        'status',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(Logins::class, 'user_id');
    }

    public static function notificationsFor(?Logins $user, int $limit = 6): Collection
    {
        if (!$user) {
            return collect();
        }

        $query = static::with('user')->latest();

        if (!$user->isSuperAdmin()) {
            $query->where('user_id', $user->id);
        }

        return $query
            ->take($limit)
            ->get()
            ->map(function (self $order) use ($user) {
                $customerName = $order->user?->username ?? 'Guest';
                $formattedTotal = number_format((float) $order->total_amount, 2);

                return [
                    'id' => $order->id,
                    'title' => 'Order #' . $order->id,
                    'message' => $user->isSuperAdmin()
                        ? "{$customerName} placed an order for \${$formattedTotal}"
                        : "Your order total is \${$formattedTotal}",
                    'customer' => $customerName,
                    'status' => ucfirst((string) $order->status),
                    'time' => $order->created_at?->diffForHumans() ?? 'Just now',
                    'created_at' => $order->created_at?->toIso8601String(),
                ];
            })
            ->values();
    }
}
