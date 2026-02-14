{{-- @include('includes.header')

<main>
    <section class="section-10">
        <div class="container">
            <div class="login-form mx-auto" style="max-width: 400px;">

                <form action="{{ route('admin.register.submit') }}" method="POST">
                    @csrf

                    <h4 class="text-center mb-4">Register New Account</h4>

                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="John Doe"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="user@example.com"
                               value="{{ old('email') }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimum 8 characters"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Password must be at least 8 characters long.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               placeholder="Re-enter password"
                               required>
                    </div>

                    {{-- Role Selection --}}
                    <div class="mb-3">
                        <label for="role" class="form-label">Select Role</label>
                        <select name="role"
                                id="role"
                                class="form-select @error('role') is-invalid @enderror"
                                required>
                            <option value="">-- Choose Role --</option>
                            <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>
                                User (Regular Account)
                            </option>
                            <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>
                                Admin (Full Access)
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <small class="text-muted">
                                <strong>User:</strong> Regular account with limited access<br>
                                <strong>Admin:</strong> Full administrative access
                            </small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark w-100">
                        Register
                    </button>
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

@include('includes.footer') --}}
