@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="content">
    <div class="container-fluid">

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- MAIN FORM -->
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                <!-- LEFT SIDE -->
                <div class="col-md-8">

                    <!-- Title + Slug -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Product Title"
                                    value="{{ old('title', $product->title) }}"
                                    required>
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug"
                                    class="form-control"
                                    placeholder="Auto-generated slug"
                                    value="{{ old('slug', $product->slug) }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" id="description"
                                    class="form-control"
                                    rows="6"
                                    placeholder="Product Description">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Media -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>

                            <!-- Existing Images -->
                            @if($product->images->isNotEmpty())
                                <div class="row mb-3" id="existing-images">
                                    @foreach($product->images as $image)
                                        <div class="col-md-3 mb-3" id="image-{{ $image->id }}">
                                            <div class="card">
                                                <img src="{{ asset('uploads/products/thumbs/' . $image->image) }}"
                                                     class="card-img-top"
                                                     alt="Product Image">
                                                <div class="card-body text-center p-2">
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm delete-img"
                                                            data-id="{{ $image->id }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Upload New Images -->
                            <div id="dropzone" class="dropzone dz-clickable"></div>

                            <!-- Hidden inputs for new images -->
                            <div id="hidden-images"></div>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>

                            <div class="mb-3">
                                <label for="price">Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="price" id="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    placeholder="0.00"
                                    value="{{ old('price', $product->price) }}"
                                    required>
                                @error('price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="compare_price">Compare at Price</label>
                                <input type="number" step="0.01" name="compare_price" id="compare_price"
                                    class="form-control"
                                    placeholder="0.00"
                                    value="{{ old('compare_price', $product->compare_price) }}">
                                <small class="text-muted">To show a reduced price, move the product's original price into Compare at price. Enter a lower value into Price.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="sku">SKU (Stock Keeping Unit) <span class="text-danger">*</span></label>
                                    <input type="text" name="sku" id="sku"
                                        class="form-control @error('sku') is-invalid @enderror"
                                        placeholder="SKU"
                                        value="{{ old('sku', $product->sku) }}"
                                        required>
                                    @error('sku')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="barcode">Barcode</label>
                                    <input type="text" name="barcode" id="barcode"
                                        class="form-control"
                                        placeholder="Barcode"
                                        value="{{ old('barcode', $product->barcode) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="track_qty" name="track_qty"
                                        {{ old('track_qty', $product->track_qty) == 'Yes' ? 'checked' : '' }}
                                        onchange="document.getElementById('qty-wrapper').style.display = this.checked ? 'block' : 'none';">
                                    <label class="custom-control-label" for="track_qty">Track Quantity</label>
                                </div>
                            </div>

                            <div class="mb-3" id="qty-wrapper" style="display: {{ old('track_qty', $product->track_qty) == 'Yes' ? 'block' : 'none' }};">
                                <label for="qty">Quantity</label>
                                <input type="number" min="0" name="qty" id="qty"
                                    class="form-control"
                                    placeholder="0"
                                    value="{{ old('qty', $product->qty) }}">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT SIDE -->
                <div class="col-md-4">

                    <!-- Status -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product Status</h2>

                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Block</option>
                            </select>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product Category</h2>

                            <div class="mb-3">
                                <label>Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Sub Category</label>
                                <select name="sub_category_id" id="sub_category_id" class="form-control">
                                    <option value="">-- Select Sub Category --</option>
                                    @foreach($subCategories as $subCat)
                                        <option value="{{ $subCat->id }}"
                                            {{ old('sub_category_id', $product->sub_category_id) == $subCat->id ? 'selected' : '' }}>
                                            {{ $subCat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Brand -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Brand</h2>

                            <select name="brand_id" id="brand_id" class="form-control">
                                <option value="">-- Select Brand --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Featured -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Featured Product</h2>

                            <select name="is_featured" id="is_featured" class="form-control">
                                <option value="No" {{ old('is_featured', $product->is_featured) == 'No' ? 'selected' : '' }}>No</option>
                                <option value="Yes" {{ old('is_featured', $product->is_featured) == 'Yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Buttons -->
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark ml-3">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</section>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<style>
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 5px;
        background: #f8f9fa;
        min-height: 150px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script>
// Auto-generate slug
document.getElementById('title').oninput = function() {
    document.getElementById('slug').value = this.value
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
};

// Dropzone
Dropzone.autoDiscover = false;
new Dropzone("#dropzone", {
    url: "{{ route('admin.products.uploadImage') }}",
    maxFiles: 10,
    maxFilesize: 5,
    acceptedFiles: ".jpg,.jpeg,.png,.webp",
    addRemoveLinks: true,
    dictDefaultMessage: "Drop new images here or click to upload",
    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
    success: function(file, res) {
        if(res.status) {
            document.getElementById("hidden-images").innerHTML +=
                `<input type="hidden" name="image_array[]" value="${res.image}">`;
        }
    },
    error: function(file, res) {
        alert('Upload failed: ' + (res.message || 'Unknown error'));
        this.removeFile(file);
    }
});

// Delete image
document.querySelectorAll('.delete-img').forEach(btn => {
    btn.onclick = function() {
        if(!confirm('Delete this image?')) return;

        const id = this.dataset.id;
        fetch(`{{ url('admin/products/delete-image') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status) {
                document.getElementById('image-' + id).remove();
                alert('Image deleted successfully!');
            } else {
                alert('Failed to delete image');
            }
        });
    };
});

// Load subcategories
document.getElementById('category_id').onchange = function() {
    const subSelect = document.getElementById('sub_category_id');
    subSelect.innerHTML = '<option value="">-- Select Sub Category --</option>';

    if(this.value) {
        fetch(`{{ url('admin/products/subcategories') }}/${this.value}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(sub => {
                    subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                });
            });
    }
};
</script>
@endpush
