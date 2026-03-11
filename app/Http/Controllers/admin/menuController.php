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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048', // Optional image upload
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $validated['image'] = basename($path); // Store only the filename
        }

        Product::create($validated);

        return redirect()->back()->with('success', 'Menu item added successfully!');
    }
}