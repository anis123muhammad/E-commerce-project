@extends('admin.layouts.app')

@section('title', 'New User')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create New User</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Back to Users</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2 class="h5 mb-0 pt-2 pb-2">User Details</h2>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Name" value="{{ old('name') }}" class="form-control" required>
                    </div>


                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" class="form-control" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" placeholder="Password" id="password" class="form-control" required autocomplete="new-password">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation">Confirm Password</label>
                      <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm-Password" class="form-control" required autocomplete="new-password">
                    </div>

                    <div class="mb-3">
                        <label for="role">Role</label>
                       <select name="role" id="role" class="form-control">
    <option value="">Select Role</option>
    <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>User</option>
    <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Admin</option>
</select>
                    </div>

                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Block" {{ old('status') == 'Block' ? 'selected' : '' }}>Block</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
