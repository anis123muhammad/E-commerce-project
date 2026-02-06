@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Categories</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">New Category</a>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <form action="{{ route('admin.categories.index') }}" method="GET">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text"
                                   name="search"
                                   class="form-control float-right"
                                   placeholder="Search"
                                   value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            {{-- <th width="100">Image</th> --}}
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td>{{ $cat->name }}</td>
                            <td>{{ $cat->slug }}</td>
                            {{-- <td>
                                @if($cat->image)
                                    <img src="{{ asset('uploads/categories/'.$cat->image) }}"
                                         width="50"
                                         height="50"
                                         class="img-thumbnail">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td> --}}
                            <td>
                                @if($cat->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Block</span>
                                @endif
                            </td>
                            <td>
                           <a href="{{ route('admin.categories.edit', $cat->id) }}"
   class="btn btn-sm btn-primary">
    <i class="fas fa-edit"></i>
</a>
                       <form action="{{ route('admin.categories.destroy', $cat->id) }}"
      method="POST"
      style="display:inline;">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-sm btn-danger"
            onclick="return confirm('Are you sure you want to delete this category?')">
        <i class="fas fa-trash"></i>
    </button>
</form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No categories found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted">
                            Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }}
                            of {{ $categories->total() }} entries
                        </p>
                    </div>
                    <div class="col-md-6">
                        {{ $categories->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
