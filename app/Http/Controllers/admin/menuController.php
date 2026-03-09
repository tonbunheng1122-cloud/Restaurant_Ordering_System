<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Category;

class MenuController extends Controller
{
    // Show Menu Page
    public function pageMenu()
    {
        $categories = Category::withCount('products')
            ->get()
            ->map(function($cat){
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'count' => $cat->products_count.' Items'
                ];
            });

        $products = Product::with('category')
            ->get()
            ->map(function($p){
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => (float)$p->price,
                    'category' => $p->category->name ?? 'Uncategorized',
                    'image' => $p->images[0] ?? null ,
                ];
            });

        return view('admin.itemMenu.menu', compact('categories','products'));
    }

    // // Store new Product
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|max:255',
    //         'price' => 'required|numeric|min:0',
    //         'category_id' => 'required|exists:categories,id',
    //         'image' => 'nullable|image|max:2048'
    //     ]);

    //     $data = $request->only(['name', 'price', 'category_id']);

    //     if ($request->hasFile('image')) {
    //         $path = $request->file('image')->store('menus', 'public');
    //         $data['image'] = $path;
    //     }

    //     Product::create($data); // use Product model

    //     return redirect()->route('menu.page')->with('success', 'Menu Item Created Successfully!');
    // }
}