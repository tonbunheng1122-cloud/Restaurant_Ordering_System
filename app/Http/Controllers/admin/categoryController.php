<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //========================================
    // LIST + SEARCH
    //========================================
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

    // CREATE PAGE
    public function pageAddcategory()
    {
        return view('admin.itemMenu.addcategory');
    }

    // STORE
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

    // EDIT
   public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.itemMenu.addcategory', compact('category'));
    }

    // UPDATE
    public function update(Request $request,$id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255|unique:categories,name,'.$id,
        ]);

        $category->update($request->only('name','description'));

        return redirect()->route('allcategory.index')
            ->with('success','Category Updated Successfully!');
    }

    // DELETE
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->route('allcategory.index')
            ->with('success','Category Deleted!');
    }
}