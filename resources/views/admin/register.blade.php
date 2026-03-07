    @include('includes.header')

    <main>
        <section class="section-10">
            <div class="container">
                <div class="login-form mx-auto" style="max-width: 400px;">

                 <form action="{{ route('admin.register.submit') }}" method="POST">
    @csrf
    <h4 class="text-center mb-4">Register New Account</h4>

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-dark w-100">Register</button>
</form>

                    <p class="text-center mt-3">
                        Already have an account?
                        <a href="{{ route('admin.login') }}" class="text-decoration-none">
                            Login here
                        </a>
                    </p>

                </div>
            </div>
        </section>
    </main>

    @include('includes.footer')
