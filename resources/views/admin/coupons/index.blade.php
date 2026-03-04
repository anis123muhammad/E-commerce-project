@extends('admin.layouts.app')

@section('title', 'Coupons')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Coupons</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                    New Coupon
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
<div class="card-body table-responsive p-0">

<table class="table table-hover text-nowrap">
<thead>
<tr>
<th>ID</th>
<th>Code</th>
<th>Name</th>
<th>Type</th>
<th>Discount</th>
<th>Min Amount</th>
<th>Status</th>
<th>Expires</th>
<th>Action</th>
</tr>
</thead>
<tbody>

@forelse($coupons as $coupon)
<tr>
<td>{{ $coupon->id }}</td>
<td>{{ $coupon->code }}</td>
<td>{{ $coupon->name }}</td>
<td>
    <span class="badge badge-info">
        {{ ucfirst($coupon->type) }}
    </span>
</td>
<td>
    @if($coupon->type == 'percent')
        {{ $coupon->discount_amount }}%
    @else
        ${{ $coupon->discount_amount }}
    @endif
</td>
<td>${{ number_format($coupon->min_amount, 2) }}</td>
<td>
    @if($coupon->status)
        <span class="badge badge-success">Active</span>
    @else
        <span class="badge badge-danger">Inactive</span>
    @endif
</td>
<td>{{ $coupon->expires_at }}</td>
<td>
    <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
       class="btn btn-sm btn-primary">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}"
          method="POST"
          style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="btn btn-sm btn-danger"
                onclick="return confirm('Delete this coupon?')">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</td>
</tr>

@empty
<tr>
<td colspan="9" class="text-center">No coupons found</td>
</tr>
@endforelse

</tbody>
</table>

</div>

<div class="card-footer clearfix">
    {{ $coupons->links('pagination::bootstrap-4') }}
</div>

</div>
</div>
</section>
@endsection
