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
                            <h2 class="h5 mb-0 pt-2 pb-2">Forgot Password</h2>
                        </div>

                        <div class="card-body p-4">

<form action="{{ route('password.email') }}" method="POST">
@csrf

<div class="mb-3">
<label for="email">Email</label>
<input
type="email"
name="email"
id="email"
placeholder="Enter your registered email"
value="{{ old('email') }}"
class="form-control"
required>
</div>

<button type="submit" class="btn btn-dark">
Send Password Reset Link
</button>

</form>

                        </div>
                    </div>



                </div>
            </div>
        </div>
    </section>

</main>
@endsection
