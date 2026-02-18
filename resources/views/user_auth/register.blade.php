@extends('user_auth.layouts.app')


@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Register</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">
                <form action="{{ route('user_auth.registerPost') }}" method="POST">
    @csrf

    <h4 class="modal-title">Register Now</h4>

    <div class="form-group">
        <input type="text" class="form-control" placeholder="Name" name="name" required>
    </div>

    <div class="form-group">
        <input type="email" class="form-control" placeholder="Email" name="email" required>
    </div>

    <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
    </div>

    <div class="form-group">
        <input type="password" class="form-control" placeholder="Confirm Password" name="cpassword" required>
    </div>

    <button type="submit" class="btn btn-dark btn-block btn-lg">
        Register
    </button>
</form>

                <div class="text-center small">Already have an account? <a href="{{ route('login') }}">Login Now</a></div>
            </div>
        </div>
    </section>

@endsection
