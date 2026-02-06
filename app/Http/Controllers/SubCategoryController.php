<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SubCategory;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
public function index(Request $request)
{
    // Start the query
    $subCategories = SubCategory::with('category')->latest();

    // Search functionality
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;

        $subCategories = $subCategories->where(function($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('slug', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        });
    }
    // Paginate results (10 per page)
    $subCategories = $subCategories->paginate(10);

    // Return to view
    return view('admin.sub-categories.index', compact('subCategories'));
}



public function create()
{
    $categories = Category::all();

    return view('admin.sub-categories.create', compact('categories'));
}


public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required',
        'name'        => 'required|string|max:255',
        'slug'        => 'nullable|string|max:255',
        'status'      => 'required'
    ]);

    SubCategory::create([
        'category_id' => $request->category_id,
        'name'        => $request->name,
        'slug'        => $request->slug ?? Str::slug($request->name),
        'status'      => $request->status,
    ]);

    return redirect()->route('admin.sub-categories.index')
                     ->with('success', 'Sub-Category Created Successfully!');
}

public function edit($id)
{
    $subCategory = SubCategory::findOrFail($id);

    $categories  = Category::all();

    return view('admin.sub-categories.edit', compact('subCategory', 'categories'));
}

public function update(Request $request, $id)
{
    $subCategory = SubCategory::findOrFail($id);

    $request->validate([
        'category_id' => 'required',
        'name'        => 'required|string|max:255',
        'slug'        => 'nullable|string|max:255',
        'status'      => 'required'
    ]);

    $subCategory->update([
        'category_id' => $request->category_id,
        'name'        => $request->name,
        'slug'        => $request->slug ?? Str::slug($request->name),
        'status'      => $request->status,
    ]);

    return redirect()->route('admin.sub-categories.index')
                     ->with('success', 'Sub-Category Updated Successfully!');
}



public function destroy($id){
    $subCategory = SubCategory::findOrFail($id);

    $subCategory->delete();

    return redirect()->route('admin.sub-categories.index')
    ->with('success' , 'Sub-Category Deleted Sucessfully');
}


}
