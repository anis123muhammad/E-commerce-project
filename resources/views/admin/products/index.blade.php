@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    New Product
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="content">
    <div class="container-fluid">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">

            <!-- Search -->
            <div class="card-header">
                <div class="card-tools">
                    <form action="{{ route('admin.products.index') }}" method="GET">
                        <div class="input-group" style="width: 250px;">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="form-control float-right"
                                   placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">

                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th width="80">Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>SKU</th>
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @if($products->count() > 0)

                            @foreach($products as $product)

                                <tr>
                                    <!-- ID -->
                                    <td>{{ $product->id }}</td>

                                    <!-- Image -->
                                    <td>
                                        @if($product->images->isNotEmpty())
                                            <img src="{{ asset('uploads/products/thumbs/' . $product->images->first()->image) }}"
                                                 class="img-thumbnail"
                                                 width="50"
                                                 alt="{{ $product->title }}">
                                        @else
                                            <img src="{{ asset('admin-assets/img/default.png') }}"
                                                 class="img-thumbnail"
                                                 width="50"
                                                 alt="No Image">
                                        @endif
                                    </td>

                                    <!-- Title -->
                                    <td>
                                        <a href="{{ route('admin.products.edit', $product->id) }}">
                                            {{ $product->title }}
                                        </a>
                                    </td>

                                    <!-- Price -->
                                    <td>
                                        ${{ number_format($product->price, 2) }}
                                    </td>

                                    <!-- Quantity -->
                                    <td>
                                        @if($product->track_qty == 'Yes')
                                            {{ $product->qty ?? 0 }} left in Stock
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <!-- SKU -->
                                    <td>
                                        {{ $product->sku }}
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        @if($product->status == 1)
                                                                               <span class="badge badge-success">Active</span>

                                        @else
                                                                               <span class="badge badge-danger">Block</span>

                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                           class="btn btn-sm btn-primary">
    <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.products.destroy', $product->id) }}"
                                              method="POST"
                                              style="display:inline;"
                                              onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">
                                                 <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        @else
                            <tr>
                                <td colspan="8" class="text-center">
                                    No Products Found!
                                </td>
                            </tr>
                        @endif

                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer clearfix">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</section>

@endsection
