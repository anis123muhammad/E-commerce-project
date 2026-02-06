@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sub-Categories</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.sub-categories.create') }}" class="btn btn-primary">
                    New Sub-Category
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <form action="{{ route('admin.sub-categories.index') }}" method="GET">
                        <div class="input-group" style="width: 250px;">
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
                            <th>Category</th>
                            <th>Slug</th>
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($subCategories as $subCat)
                            <tr>
                                <td>{{ $subCat->id }}</td>

                                <td>{{ $subCat->name }}</td>

                                <td>{{ $subCat->category->name ?? 'N/A' }}</td>

                                <td>{{ $subCat->slug }}</td>

                                <td>
                                    @if($subCat->status)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Block</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('admin.sub-categories.edit', $subCat->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.sub-categories.destroy', $subCat->id) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No Sub-categories found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted">
                            Showing {{ $subCategories->firstItem() ?? 0 }}
                            to {{ $subCategories->lastItem() ?? 0 }}
                            of {{ $subCategories->total() }} entries
                        </p>
                    </div>

                    <div class="col-md-6">
                        {{ $subCategories->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
