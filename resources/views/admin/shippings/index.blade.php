@extends('admin.layouts.app')

@section('title', 'Shipping')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Shipping Charges</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.shippings.create') }}" class="btn btn-primary">
                    Add Shipping
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
                    <form action="{{ route('admin.shippings.index') }}" method="GET">
                        <div class="input-group" style="width: 250px;">
                            <input type="text"
                                   name="search"
                                   class="form-control float-right"
                                   placeholder="Search Country"
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
                            <th>Country</th>
                            <th>Shipping Amount</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($shippings as $shipping)
                            <tr>
                                <td>{{ $shipping->id }}</td>

                                <td>{{ $shipping->country->name ?? 'N/A' }}</td>

                                <td>${{ number_format($shipping->amount, 2) }}</td>

                                <td>
                                    <a href="{{ route('admin.shippings.edit', $shipping->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.shippings.delete', $shipping->id) }}"
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
                                <td colspan="4" class="text-center">
                                    No Shipping Charges Found
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
                            Showing {{ $shippings->firstItem() ?? 0 }}
                            to {{ $shippings->lastItem() ?? 0 }}
                            of {{ $shippings->total() }} entries
                        </p>
                    </div>

                    <div class="col-md-6">
                        {{ $shippings->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
