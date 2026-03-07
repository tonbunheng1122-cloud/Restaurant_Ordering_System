<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'category', 'image'];
    // បន្ថែមផ្នែកនេះដើម្បីដោះស្រាយ Error "Array to string conversion"
    protected $casts = [
        'image' => 'array',
    ];
}
