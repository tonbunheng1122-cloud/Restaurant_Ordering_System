<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class CategoryController extends Controller
{

    public function pageAllcategory(Request $request)
    {
        $query = Category::query();

        if ($request->search) {
            $query->where('name','like','%'.$request->search.'%');
        }

        $categories = $query->latest()->paginate(10);

        return view('admin.itemMenu.allcategory',
            compact('categories'));
    }

    
    public function pageAddcategory()
    {
        return view('admin.itemMenu.addcategory');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only('name','description');

        if ($request->hasFile('image')) {
            $data['image'] =
                $request->file('image')->store('categories','public');
        }

        Category::create($data);

        return redirect()->route('allcategory.index')
            ->with('success','Category Created!');
    }

    
   public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.itemMenu.addcategory', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255|unique:categories,name,'.$id,
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name','description');

        if ($request->hasFile('image')) {
            
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('allcategory.index')
            ->with('success','Category Updated Successfully!');
    }

    
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        
        $category->delete();

        return redirect()->route('allcategory.index')
            ->with('success','Category and Image Deleted Successfully!');
    }
}