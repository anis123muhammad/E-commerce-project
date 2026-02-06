@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

<form action="{{ route('admin.categories.update', $category->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name *</label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $category->name) }}"
               required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Slug</label>
        <input type="text"
               name="slug"
               class="form-control @error('slug') is-invalid @enderror"
               value="{{ old('slug', $category->slug) }}"
               placeholder="Leave blank to auto-generate">
        @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>Block</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Category Image</label>
        <input type="file"
               name="image"
               class="form-control @error('image') is-invalid @enderror"
               accept="image/jpeg,image/png,image/jpg">

        @if($category->image)
            <div class="mt-2">
                <img src="{{ asset('uploads/categories/'.$category->image) }}" width="120">
            </div>
        @endif

        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Update
    </button>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        Cancel
    </a>
</form>


            </div>
        </div>
    </div>
</section>
@endsection
