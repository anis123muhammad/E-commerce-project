@extends('user_auth.layouts.app')

@section('content')
<main>

    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item">
                        <a class="white-text" href="#">My Account</a>
                    </li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-11">
        <div class="container mt-5">
            <div class="row">

                @include('front.account_layouts.app')

                <div class="col-md-9">

                    <!-- Personal Information Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                        </div>

                        <div class="card-body p-4">
                           <form method="POST" action="{{ route('user.updatePersonal') }}">
    @csrf
    <div class="mb-3">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control">

    </div>

    <div class="mb-3">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label for="password">Password (leave blank if no change)</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="mb-3">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>

    <button class="btn btn-dark">Update</button>
</form>
                        </div>
                    </div>

                    <!-- Address Details Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Address details</h2>
                        </div>

                        <div class="card-body p-4">
                       <form method="POST" action="{{ route('user.updateAddress') }}">
    @csrf
    <div class="mb-3">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $address->first_name ?? '') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $address->last_name ?? '') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="{{ old('email', $address->email ?? $user->email) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label for="mobile">Mobile</label>
        <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $address->mobile ?? '') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label for="country_id">Country</label>
        <select name="country_id" id="country_id" class="form-control">
            <option value="">Select a Country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" {{ old('country_id', $address->country_id ?? '') == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control">{{ old('address', $address->address ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="apartment">Apartment / Unit</label>
        <input type="text" name="apartment" id="apartment" value="{{ old('apartment', $address->apartment ?? '') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label for="city">City</label>
        <input type="text" name="city" id="city" value="{{ old('city', $address->city ?? '') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label for="state">State</label>
        <input type="text" name="state" id="state" value="{{ old('state', $address->state ?? '') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label for="zip">ZIP</label>
        <input type="text" name="zip" id="zip" value="{{ old('zip', $address->zip ?? '') }}" class="form-control">
    </div>

    <button class="btn btn-dark">Update</button>
</form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</main>
@endsection
