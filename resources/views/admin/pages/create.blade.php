@extends('admin.layouts.app')

@section('title', 'Create Page')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Page</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-primary">Back to Pages</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2 class="h5 mb-0 pt-2 pb-2">Pages</h2>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.pages.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" class="form-control" autocomplete="off">
                    </div>
                    
  <div class="mb-3">
                        <label>Slug</label>
                        <input type="text"
                               name="slug"
                               class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug') }}"
                               placeholder="Leave blank to auto-generate">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label>Content</label>
                        <textarea name="content" id="content" placeholder="Content" class="form-control" autocomplete="off">{{ old('content') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Block" {{ old('status') == 'Block' ? 'selected' : '' }}>Block</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Create</button>
                </form>

            </div>
        </div>

    </div>
</section>
@endsection
