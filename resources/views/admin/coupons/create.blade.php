@extends('admin.layouts.app')

@section('title', 'Create Sub-Category')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Coupon Code</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">
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

                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf

                    {{-- Code --}}
                    <div class="mb-3">
                        <label>Code</label>
                        <input type="text"
                               name="code"
                               class="form-control @error('code') is-invalid @enderror"
                               value="{{ old('code') }}"
                               required>

                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div class="mb-3">
                        <label>Name *</label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label>Description *</label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  required>{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Max Users --}}
                    <div class="mb-3">
                        <label>Max users *</label>
                        <input type="number"
                               name="max_users"
                               class="form-control @error('max_users') is-invalid @enderror"
                               value="{{ old('max_users') }}"
                               required>

                        @error('max_users')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Max User Uses --}}
                    <div class="mb-3">
                        <label>Max Users Use *</label>
                        <input type="number"
                               name="max_user_uses"
                               class="form-control @error('max_user_uses') is-invalid @enderror"
                               value="{{ old('max_user_uses') }}"
                               required>

                        @error('max_user_uses')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Type --}}
                    <div class="mb-3">
                        <label>Type</label>
                        <select name="type" id="coupon_type" class="form-control @error('type') is-invalid @enderror" required>
    <option value="">-- Select Type --</option>
    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percentage</option>
    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
</select>

                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Discount Amount --}}
                    <div class="mb-3">
    <label>Discount Amount *</label>

    <div class="input-group">
        <input type="number"
               step="0.01"
               name="discount_amount"
               id="discount_amount"
               class="form-control @error('discount_amount') is-invalid @enderror"
               value="{{ old('discount_amount', isset($coupon) ? $coupon->discount_amount : '') }}"
               required>

        <div class="input-group-append">
            <span class="input-group-text" id="discount_symbol">$</span>
        </div>
    </div>

    @error('discount_amount')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

                    {{-- Minimum Amount --}}
                    <div class="mb-3">
                        <label>Minimum amount *</label>
                        <input type="number"
                               name="minimum_amount"
                               class="form-control @error('minimum_amount') is-invalid @enderror"
                               value="{{ old('minimum_amount') }}"
                               required>

                        @error('minimum_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label>Status</label>
                       <select name="status" class="form-control @error('status') is-invalid @enderror" required>
    <option value="">-- Select --</option>
    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
</select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Starts At --}}
                    <div class="mb-3">
                        <label>Starts at *</label>
                        <input type="datetime-local"
                               id="starts_at"
                               name="starts_at"
                               class="form-control @error('starts_at') is-invalid @enderror"
                               value="{{ old('starts_at') }}"
                               required>

                        @error('starts_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Expires At --}}
                    <div class="mb-3">
                        <label>Expires at *</label>
                        <input type="datetime-local"
                               id="expires_at"
                               name="expires_at"
                               class="form-control @error('expires_at') is-invalid @enderror"
                               value="{{ old('expires_at') }}"
                               required>

                        @error('expires_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Coupon
                    </button>

                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>

                </form>

            </div>
        </div>
    </div>
</section>
@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const typeSelect = document.getElementById('coupon_type');
    const symbol = document.getElementById('discount_symbol');

    function updateSymbol() {
        if (typeSelect.value === 'percent') {
            symbol.innerText = '%';
        } else {
            symbol.innerText = '$';
        }
    }

    // Run on page load
    updateSymbol();

    // Run when type changes
    typeSelect.addEventListener('change', updateSymbol);
});
</script>
@endpush
