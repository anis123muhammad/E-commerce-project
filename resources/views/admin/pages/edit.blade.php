@extends('admin.layouts.app')

@section('title','Edit Page')

@section('content')

<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row">
            <div class="col-sm-6">
                <h1>Edit Page</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card">
<div class="card-body">

<form action="{{ route('admin.pages.update',$page->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" value="{{ old('name', $page->name) }}" class="form-control">
</div>

<div class="mb-3">
    <label>Slug</label>
    <input type="text"
           name="slug"
           class="form-control @error('slug') is-invalid @enderror"
           value="{{ old('slug', $page->slug) }}"
           placeholder="Leave blank to auto-generate">
    @error('slug')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



<div class="mb-3">
<label>Content</label>
<textarea name="content" id="content" placeholder="Content" class="form-control" autocomplete="off">{{ old('content', $page->content) }}</textarea>
</div>

<div class="mb-3">
<label>Status</label>
<select name="status" class="form-control">
    <option value="Active" {{ old('status', $page->status)=='Active' ? 'selected':'' }}>Active</option>
    <option value="Block" {{ old('status', $page->status)=='Block' ? 'selected':'' }}>Block</option>
</select>
</div>

<button class="btn btn-success">Update Page</button>

</form>

</div>
</div>

</div>
</section>

@endsection
