@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Product</h1>
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

        <!-- ✅ MAIN FORM START -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf

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
                                    value="{{ old('title') }}"
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
                                    value="{{ old('slug') }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" id="description"
                                    class="form-control"
                                    rows="6"
                                    placeholder="Product Description">{{ old('description') }}</textarea>
                            </div>


                                          <div class="mb-3">
    <label for="short_description">Short Description</label>
    <textarea name="short_description" id="short_description" class="form-control"
        rows="6" placeholder="Product Short Description"></textarea>
</div>

                         <div class="mb-3">
    <label for="shipping_returns">Shipping Returns</label>
    <textarea name="shipping_returns" id="shipping_returns" class="form-control"
        rows="6" placeholder="Shipping Returns"></textarea>
</div>

                        </div>
                    </div>

                    <!-- Media -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>

                            <div id="dropzone" class="dropzone dz-clickable"></div>

                            <!-- ✅ Hidden inputs inside form -->
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
                                    value="{{ old('price') }}"
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
                                    value="{{ old('compare_price') }}">
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
                                        value="{{ old('sku') }}"
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
           value="{{ old('barcode') }}"
           readonly>
</div>

                            </div>

                            <div class="mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="track_qty" name="track_qty"
                                        {{ old('track_qty', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="track_qty">Track Quantity</label>
                                </div>
                            </div>

                            <div class="mb-3" id="qty-wrapper">
                                <label for="qty">Quantity</label>
                                <input type="number" min="0" name="qty" id="qty"
                                    class="form-control"
                                    placeholder="0"
                                    value="{{ old('qty', 0) }}">
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
                                <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Block</option>
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
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                                <option value="No" {{ old('is_featured', 'No') == 'No' ? 'selected' : '' }}>No</option>
                                <option value="Yes" {{ old('is_featured') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </div>
{{-- related products --}}
                                    <div class="card mb-3">
    <div class="card-body">
        <h2 class="h4 mb-3">Related Product</h2>

      <select name="related_products" id="related_products" class="form-control">
    <option value="No" {{ old('related_products', 'No') == 'No' ? 'selected' : '' }}>No</option>
    <option value="Yes" {{ old('related_products') == 'Yes' ? 'selected' : '' }}>Yes</option>
</select>
    </div>
</div>

                </div>
            </div>

            <!-- Buttons -->
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark ml-3">
                    Cancel
                </a>
            </div>

        </form>
        <!-- ✅ MAIN FORM END -->

    </div>
</section>

@endsection

@push('styles')
<!-- Dropzone CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<style>
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 5px;
        background: #f8f9fa;
        min-height: 150px;
    }
    .dropzone .dz-message {
        font-size: 1.2rem;
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<!-- Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

<script>
// ✅ Auto-generate Slug from Title
document.getElementById('title').addEventListener('input', function() {
    let title = this.value;
    let slug = title.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    document.getElementById('slug').value = slug;
});

// ✅ Dropzone Configuration
Dropzone.autoDiscover = false;

let myDropzone = new Dropzone("#dropzone", {
    url: "{{ route('admin.products.uploadImage') }}",
    maxFiles: 10,
    maxFilesize: 5, // MB
    acceptedFiles: ".jpg,.jpeg,.png,.webp",
    addRemoveLinks: true,
    dictDefaultMessage: "Drop images here or click to upload",
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },

    success: function(file, response) {
        if(response.status) {
            // Add hidden input for each uploaded image
            document.getElementById("hidden-images").innerHTML +=
                `<input type="hidden" name="image_array[]" value="${response.image}">`;

            console.log('Image uploaded:', response.image);
        }
    },

    error: function(file, response) {
        alert('Image upload failed: ' + (response.message || 'Unknown error'));
        this.removeFile(file);
    },

    removedfile: function(file) {
        // Remove from hidden inputs if exists
        if(file.xhr) {
            let response = JSON.parse(file.xhr.response);
            if(response.image) {
                let inputs = document.querySelectorAll('input[name="image_array[]"]');
                inputs.forEach(input => {
                    if(input.value === response.image) {
                        input.remove();
                    }
                });
            }
        }

        // Remove preview element
        if(file.previewElement) {
            file.previewElement.remove();
        }
    }
});

// ✅ Load Subcategories on Category Change
document.getElementById('category_id').addEventListener('change', function() {
    let categoryId = this.value;
    let subCategorySelect = document.getElementById('sub_category_id');

    // Clear existing options
    subCategorySelect.innerHTML = '<option value="">-- Select Sub Category --</option>';

    if(categoryId) {
        fetch(`{{ url('admin/products/subcategories') }}/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(subcat => {
                    let option = document.createElement('option');
                    option.value = subcat.id;
                    option.textContent = subcat.name;
                    subCategorySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading subcategories:', error));
    }
});

// ✅ Toggle Quantity Field
document.getElementById('track_qty').addEventListener('change', function() {
    document.getElementById('qty-wrapper').style.display = this.checked ? 'block' : 'none';
});
</script>
@endpush
