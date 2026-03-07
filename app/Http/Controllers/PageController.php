<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{

public function index(Request $request)
{
    $pages = Page::when($request->search, function ($query, $search) {
        $query->where('name', 'like', "%{$search}%")
              ->orWhere('slug', 'like', "%{$search}%");
    })
    ->latest()
    ->paginate(10)
    ->appends($request->only('search')); // keeps search term in pagination links

    return view('admin.pages.index', compact('pages'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        return view('admin.pages.create');
    }

public function store(Request $request)
{
    // Validate required fields
    $request->validate([
        'name' => 'required',
        'content' => 'required',
        'slug' => 'nullable|unique:pages,slug', // optional, must be unique
    ]);

    // Generate slug if not provided
    $slug = $request->slug ?: Str::slug($request->name);

    // Create page
    Page::create([
        'name' => $request->name,
        'slug' => $slug,
        'content' => $request->Content,
        'status' => $request->status ?? 'Active', // default to Active
    ]);

    return redirect()->route('admin.pages.index')
                     ->with('success', 'Page created successfully!');
}

    /**u
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {

    $page = Page::findOrFail($id);

    return view('admin.pages.edit',compact('page'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          $page = Page::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:pages,slug,' . $id,
            'content' => 'required'
        ]);

        $page->update($request->all());

        return redirect()->route('admin.pages.index')
        ->with('success','page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.pages.index')
        ->with('success','page deleted successfully');
    }
}
