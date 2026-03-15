<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ✅ Add this relation to fix the error
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}