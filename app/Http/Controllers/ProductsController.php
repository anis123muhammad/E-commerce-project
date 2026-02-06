<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    // List all products
    public function index(Request $request)
    {
        $products = Product::with('images')
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    // Show create form
    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::where('status', 1)->get(),
            'brands' => Brand::where('status', 1)->get()
        ]);
    }

    // Store new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|unique:products,sku',
        ]);

        $product = Product::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'brand_id' => $request->brand_id,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'track_qty' => $request->track_qty ? 'Yes' : 'No',
            'qty' => $request->qty ?? 0,
            'is_featured' => $request->is_featured ?? 'No',
            'status' => $request->status ?? 1,
        ]);

        // Save images
        if ($request->image_array) {
            foreach ($request->image_array as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image,
                    'sort_order' => $index + 1
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::where('status', 1)->get(),
            'brands' => Brand::where('status', 1)->get(),
            'subCategories' => SubCategory::where('category_id', $product->category_id)
                ->where('status', 1)
                ->get()
        ]);
    }

    // Update product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
        ]);

        $product->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'brand_id' => $request->brand_id,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'track_qty' => $request->track_qty ? 'Yes' : 'No',
            'qty' => $request->qty ?? 0,
            'is_featured' => $request->is_featured ?? 'No',
            'status' => $request->status ?? 1,
        ]);

        // Save new images
        if ($request->image_array) {
            foreach ($request->image_array as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image,
                    'sort_order' => $index + 1
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete all product images
        foreach ($product->images as $image) {
            $this->removeImageFiles($image->image);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    // Upload image (Dropzone)
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120'
        ]);

        $imageName = time() . '_' . uniqid() . '.' . $request->file('file')->extension();

        // Create directories
        $this->ensureDirectoriesExist();

        // Save images
        Image::read($request->file('file'))
            ->scale(width: 800)
            ->save(public_path('uploads/products/' . $imageName));

        Image::read($request->file('file'))
            ->cover(150, 150)
            ->save(public_path('uploads/products/thumbs/' . $imageName));

        return response()->json([
            'status' => true,
            'image' => $imageName,
            'message' => 'Image uploaded successfully'
        ]);
    }

    // Delete single image (AJAX)
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $this->removeImageFiles($image->image);
        $image->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully'
        ]);
    }

    // Get subcategories by category
    public function getSubcategories($categoryId)
    {
        return response()->json(
            SubCategory::where('category_id', $categoryId)
                ->where('status', 1)
                ->get()
        );
    }

    // Helper: Remove image files
    private function removeImageFiles($imageName)
    {
        File::delete([
            public_path('uploads/products/' . $imageName),
            public_path('uploads/products/thumbs/' . $imageName)
        ]);
    }

    // Helper: Ensure upload directories exist
    private function ensureDirectoriesExist()
    {
        $paths = [
            public_path('uploads/products'),
            public_path('uploads/products/thumbs')
        ];

        foreach ($paths as $path) {
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }
    }
}
