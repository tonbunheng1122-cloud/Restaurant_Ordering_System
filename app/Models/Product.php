<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'qty',
        'price',
        'cost',
        'count',
        'description',
        'category_id',
        'images'
    ];
    // បន្ថែមផ្នែកនេះដើម្បីដោះស្រាយ Error "Array to string conversion"
    protected $casts = [
        'images' => 'array',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}