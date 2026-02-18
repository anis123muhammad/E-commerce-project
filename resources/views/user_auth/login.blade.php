@extends('user_auth.layouts.app')

@section('content')


    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Login</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">
                <form action="{{ route('user_auth.loginPost') }}" method="POST">
    @csrf

    <h4 class="modal-title">Login to Your Account</h4>

    <div class="form-group">
        <input type="text" name="email" class="form-control" placeholder="Email" required>
    </div>

    <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>

    <input type="submit" class="btn btn-dark btn-block btn-lg" value="Login">
</form>

                <div class="text-center small">Don't have an account? <a href="{{ route('user_auth.register') }}">Sign up</a></div>
            </div>
        </div>
    </section>


    @endsection
