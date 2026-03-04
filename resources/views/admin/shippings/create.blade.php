@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.shippings.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Select Country</label>
                <select name="country_id" class="form-control">
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Shipping Price</label>
                <input type="number" name="shipping_price" class="form-control">
            </div>

            <button class="btn btn-primary">Save</button>
        </form>

    </div>
</div>
@endsection
