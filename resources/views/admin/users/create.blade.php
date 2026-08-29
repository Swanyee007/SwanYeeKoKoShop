@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h4>Create User Account</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.users.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

<!-- User Name -->
<div class="mb-3">
    <label class="form-label">User Name</label>
    <input type="text"
           name="name"
           value="{{old('name')}}"
           class="form-control  @error ('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
</div>

<!-- Phone Number -->
<div class="mb-3">
    <label class="form-label">Phone Number</label>
    <input type="text"
           name="phone"
           value="{{old('phone')}}"
           class="form-control  @error ('phone') is-invalid @enderror">
        @error('phone')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
</div>

<!-- Profile -->
<div class="mb-3">
    <label class="form-label">Profile</label>
    <input type="file"
           accept="image/*"
           name="profile"
           class="form-control  @error ('profile') is-invalid @enderror">
    @error('profile')
            <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>


<!-- Email -->
<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email"
           name="email"
           value="{{old('email')}}"
           class="form-control  @error ('email') is-invalid @enderror">
        @error('email')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
</div>


<!-- Password -->
<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password"
           name="password"
           value="{{old('password')}}"
           class="form-control  @error ('password') is-invalid @enderror">
        @error('password')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
</div>


<!-- Confirm Password -->
<div class="mb-3">
    <label class="form-label">Confirm Password</label>
    <input type="password"
           name="password_confirmation" required autocomplete="new-password"
           class="form-control">
</div>

<!-- Role -->
<div class="mb-3">
    <label class="form-label">Select User Or Admin</label>
    <select id="role"
                class="form-select @error('role') is-invalid @enderror"
                name="role"
                required>

            <option value="">Role</option>

            <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>
                User
            </option>

            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                Admin
            </option>

        </select>
        @error('password')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror

</div>


                <!-- Buttons -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>

                    <a href="{{ route('backend.users.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
