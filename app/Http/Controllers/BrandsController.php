<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class BrandsController extends Controller
{
    // ✅ Show All Brands + Search + Pagination
    public function index(Request $request)
    {
        $brands = Brand::latest();

        // 🔍 Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $brands = $brands->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        // Pagination
        $brands = $brands->paginate(10);

        return view('admin.brands.index', compact('brands'));
    }

    // ✅ Create Page
    public function create()
    {
        return view('admin.brands.create');
    }

    // ✅ Store Brand
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name'   => 'required|string|max:255',
            'slug'   => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        // Create Brand
        Brand::create([
            'name'   => $request->name,
            'slug'   => $request->slug ?: Str::slug($request->name),
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand created successfully!');
    }

    // ✅ Edit Brand Page
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.brands.edit', compact('brand'));
    }

    // ✅ Update Brand
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'slug'   => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        $brand = Brand::findOrFail($id);

        $brand->update([
            'name'   => $request->name,
            'slug'   => $request->slug ?: Str::slug($request->name),
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand updated successfully!');
    }

    // ✅ Delete Brand
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully!');
    }
}
