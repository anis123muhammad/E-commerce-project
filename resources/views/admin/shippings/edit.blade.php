@extends('admin.layouts.app')

@section('title', 'Edit Shipping')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Shipping</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.shippings.index') }}" class="btn btn-primary">
                    Back
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Edit Form --}}
                <form action="{{ route('admin.shippings.update', $shipping->id) }}"
                      method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Country Dropdown --}}
                    <div class="mb-3">
                        <label>Country *</label>
                        <select name="country_id"
                                class="form-control @error('country_id') is-invalid @enderror"
                                required>
                            <option value="">-- Select Country --</option>

                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id', $shipping->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Shipping Amount --}}
                    <div class="mb-3">
                        <label>Shipping Amount *</label>
                        <input type="number"
                               step="0.01"
                               name="amount"
                               class="form-control @error('amount') is-invalid @enderror"
                               value="{{ old('amount', $shipping->amount) }}"
                               required>

                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>

                    <a href="{{ route('admin.shippings.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </form>

            </div>
        </div>
    </div>
</section>
@endsection
