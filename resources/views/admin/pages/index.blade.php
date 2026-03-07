@extends('admin.layouts.app')

@section('title', 'Pages')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pages</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">New Page</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
    <div class="card-tools">
        <form action="{{ route('admin.pages.index') }}" method="GET">
            <div class="input-group" style="width: 250px;">
                <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ request('search') }}">
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
                                {{-- <th>Content</th> --}}
                                {{-- <th width="100">Status</th> --}}
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                    <tbody>

@foreach ($pages as $page)

<tr>

<td>{{ $page->id }}</td>

<td>{{ $page->name }}</td>

<td>{{ $page->slug }}</td>

{{-- <td>{{ $page->content }}</td> --}}

{{-- <td>

@if($page->status == 'Active')
<span class="badge badge-success">Active</span>
@else
<span class="badge badge-danger">Block</span>
@endif

</td> --}}

<td>

<a href="{{ route('admin.pages.edit',$page->id) }}" class="btn btn-sm btn-primary">
    <i class="fas fa-edit"></i>
Edit
</a>

<form action="{{ route('admin.pages.destroy',$page->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger">
    <i class="fas fa-trash"></i></button>

</form>

</td>

</tr>

@endforeach

</tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
<div class="card-footer clearfix">
    {{ $pages->links() }}
</div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->



@endsection
