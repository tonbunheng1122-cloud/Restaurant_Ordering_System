<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhereHas('category', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%");
                  });
            });
        }
        $products = $query->latest()->paginate(10)->withQueryString();
        return view('admin.itemMenu.allproduct', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.itemMenu.addproduct', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'qty'         => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'cost'        => 'required|numeric|min:0',
            'count'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'images'      => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['name','qty','price','cost','count','description','category_id']);

        if ($request->hasFile('images')) {
            $path = $request->file('images')->store('products', 'public');
            $data['images'] = [$path]; // រក្សាទុកជា Array សម្រាប់ JSON Casting
        }

        Product::create($data);
        return redirect()->route('allproduct.index')->with('success', 'Product Created Successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.itemMenu.addproduct', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name'        => 'required|max:255',
            'qty'         => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'cost'        => 'required|numeric|min:0',
            'count'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'images'      => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['name','qty','price','cost','count','description','category_id']);

        if ($request->hasFile('images')) {
            // លុបរូបចាស់
            if ($product->images && is_array($product->images)) {
                foreach($product->images as $oldImg) {
                    Storage::disk('public')->delete($oldImg);
                }
            }
            $path = $request->file('images')->store('products', 'public');
            $data['images'] = [$path]; 
        }

        $product->update($data);
        return redirect()->route('allproduct.index')->with('success', 'Product Updated Successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->images && is_array($product->images)) {
            foreach($product->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }
        $product->delete();
        return redirect()->route('allproduct.index')->with('success', 'Product Deleted Successfully!');
    }
}