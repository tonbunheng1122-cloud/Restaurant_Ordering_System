<?php
namespace App\Http\Controllers\layouts;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class UserwebController extends Controller
{
    public function pages()
    {
    $categories = Category::withCount('products')->get();
        $products   = Product::with('category')->get(); 
        return view('layouts.userweb', compact('categories', 'products'));
    }
    public function tableOrder($tableNumber)
    {
        $categories = Category::withCount('products')->get();
        $products   = Product::with('category')->where('qty', '>=', 0)->get();
        return view('layouts.table-order', compact('categories', 'products', 'tableNumber'));
    }
}