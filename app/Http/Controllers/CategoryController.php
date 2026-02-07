<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::latest();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $categories = $categories->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        // Paginate results (10 per page)
        $categories = $categories->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'status' => 'required|in:0,1',
        'showHome' => 'required|in:Yes,No',
        ]);

        $imageName = null;

        // Handle image upload if file is present
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Create directory if it doesn't exist
            $uploadPath = public_path('uploads/categories');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Move the uploaded file (simple, no resizing)
            $file->move($uploadPath, $imageName);

            \Log::info('Image saved successfully: ' . $imageName);
        }

        // Create category
        $category = Category::create([
            'name'   => $request->name,
            'slug'   => $request->slug ?: Str::slug($request->name),
            'image'  => $imageName,
            'status' => $request->status,
        'showHome' => $request->showHome,  // Remove the ?? 'No' part

        ]);

        \Log::info('Category created:', $category->toArray());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Create directory if it doesn't exist
            $uploadPath = public_path('uploads/categories');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Move the uploaded file (simple, no resizing)
            $file->move($uploadPath, $filename);

            return response()->json(['image' => $filename]);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }


    public function edit($id){

    $category = Category::findOrFail($id);

return view('admin.categories.edit' , compact('category'));
    }


public function update(Request $request, $id)
{
    $request->validate([
        'name'   => 'required|string|max:255',
        'slug'   => 'nullable|string|max:255',
        'status' => 'required|boolean',
        'image'  => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        'showHome' => 'required|in:Yes,No',

    ]);

    $category = Category::findOrFail($id);

    $data = [
        'name'   => $request->name,
        'slug'   => $request->slug,
        'status' => $request->status,
        'showHome' => $request->showHome,  // Remove the ?? 'No' part

    ];

    // 🔥 IMAGE UPDATE LOGIC
    if ($request->hasFile('image')) {

        // delete old image
        $oldImagePath = public_path('uploads/categories/' . $category->image);
        if ($category->image && File::exists($oldImagePath)) {
            File::delete($oldImagePath);
        }

        // upload new image
        $image     = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/categories'), $imageName);

        $data['image'] = $imageName;
    }

    $category->update($data);

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Category updated successfully');

        }


        public function destroy($id){

        $category = Category::findOrFail($id);
        if ($category->image){
            $imagepath = public_path('uploads/categories/'.$category->image);
            if(File::exists($imagepath)){
                File::delete($imagepath);
            }
        }
        $category->delete();
        return redirect()
        ->route('admin.categories.index')
        ->with('sucess','category deleted sucessfully');
        }

}
