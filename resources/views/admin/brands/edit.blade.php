@extends('admin.layouts.app')

@section('title', 'Edit Brand')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Brand</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.brands.index') }}" class="btn btn-primary">Back</a>
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

<form action="{{ route('admin.brands.update', $brand->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name *</label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $brand->name) }}"
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
               value="{{ old('slug', $brand->slug) }}"
               placeholder="Leave blank to auto-generate">
        @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>Block</option>
        </select>
    </div>


    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Update
    </button>

    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
        Cancel
    </a>
</form>


            </div>
        </div>
    </div>
</section>
@endsection
