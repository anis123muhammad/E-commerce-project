@extends('admin.layouts.app')

@section('title', 'Edit Coupon')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Coupon</h1>
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

                <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Code --}}
                    <div class="mb-3">
                        <label>Code</label>
                        <input type="text" name="code"
                               class="form-control @error('code') is-invalid @enderror"
                               value="{{ old('code', $coupon->code) }}" required>
                        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Name --}}
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $coupon->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  required>{{ old('description', $coupon->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Max Users --}}
                    <div class="mb-3">
                        <label>Max Users</label>
                        <input type="number" name="max_users"
                               class="form-control"
                               value="{{ old('max_users', $coupon->max_uses) }}" required>
                    </div>

                    {{-- Max Users Per User --}}
                    <div class="mb-3">
                        <label>Max Users Per User</label>
                        <input type="number" name="max_user_uses"
                               class="form-control"
                               value="{{ old('max_user_uses', $coupon->max_uses_per_user) }}" required>
                    </div>

                    {{-- Type --}}
                    <div class="mb-3">
                        <label>Type</label>
                        <select name="type" class="form-control" required>
                            <option value="percent"
                                {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>
                                Percentage
                            </option>
                            <option value="fixed"
                                {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>
                                Fixed
                            </option>
                        </select>
                    </div>

                    {{-- Discount --}}
                    {{-- Discount --}}
<div class="mb-3">
    <label>Discount Amount</label>

    <div class="input-group">
        <input type="number" step="0.01" name="discount_amount"
               id="discount_amount"
               class="form-control"
               value="{{ old('discount_amount', $coupon->discount_amount) }}" required>

        <div class="input-group-append">
            <span class="input-group-text" id="discount_symbol">
                {{ old('type', $coupon->type) == 'percent' ? '%' : '$' }}
            </span>
        </div>
    </div>
</div>

                    {{-- Minimum Amount --}}
                    <div class="mb-3">
                        <label>Minimum Amount</label>
                        <input type="number" step="0.01" name="minimum_amount"
                               class="form-control"
                               value="{{ old('minimum_amount', $coupon->min_amount) }}" required>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="1"
                                {{ old('status', $coupon->status) == 1 ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="0"
                                {{ old('status', $coupon->status) == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    {{-- Starts At --}}
                    <div class="mb-3">
                        <label>Starts At</label>
                        <input type="datetime-local" name="starts_at"
                               class="form-control"
                               value="{{ old('starts_at', optional($coupon->starts_at)->format('Y-m-d\TH:i')) }}"
                               required>
                    </div>

                    {{-- Expires At --}}
                    <div class="mb-3">
                        <label>Expires At</label>
                        <input type="datetime-local" name="expires_at"
                               class="form-control"
                               value="{{ old('expires_at', optional($coupon->expires_at)->format('Y-m-d\TH:i')) }}"
                               required>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Update Coupon
                    </button>

                </form>

            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const typeSelect = document.querySelector("select[name='type']");
        const symbol = document.getElementById("discount_symbol");

        function updateSymbol() {
            if (typeSelect.value === "percent") {
                symbol.innerText = "%";
            } else {
                symbol.innerText = "$";
            }
        }

        updateSymbol(); // initial load
        typeSelect.addEventListener("change", updateSymbol);

    });
</script>
@endsection

