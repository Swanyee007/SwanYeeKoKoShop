@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h4>Edit User Account</h4>
            <a href="{{route('backend.users.index')}}" class="btn btn-danger">Cancel</a>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.users.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name -->
            <div class="mb-3">
                <label class="form-label">Name</label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Enter Name">

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label class="form-label">Phone</label>

                <input type="text"
                       name="phone"
                       value="{{ old('phone', $user->phone) }}"
                       class="form-control @error('phone') is-invalid @enderror"
                       placeholder="Enter Phone">

                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Profile -->
            <div class="mb-3">

                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item" role="presentation">
                        <button class="nav-link active"
                                id="profile-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#profile-tab-pane"
                                type="button"
                                role="tab"
                                aria-controls="profile-tab-pane"
                                aria-selected="true">
                            Profile
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link"
                                id="new_profile-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#new_profile-tab-pane"
                                type="button"
                                role="tab"
                                aria-controls="new_profile-tab-pane"
                                aria-selected="false">
                            New Profile
                        </button>
                    </li>

                </ul>


                <div class="tab-content" id="myTabContent">

                    <!-- Old Profile -->
                    <div class="tab-pane fade show active"
                         id="profile-tab-pane"
                         role="tabpanel"
                         aria-labelledby="profile-tab"
                         tabindex="0">

                        @if($user->profile)

                            <img src="{{ asset($user->profile) }}"
                                 class="w-25 h-25 my-2 rounded-circle"
                                 alt="Profile">

                            <input type="hidden"
                                   name="old_profile"
                                   value="{{ $user->profile }}">

                        @endif

                    </div>


                    <!-- New Profile -->
                    <div class="tab-pane fade"
                         id="new_profile-tab-pane"
                         role="tabpanel"
                         aria-labelledby="new_profile-tab"
                         tabindex="0">

                        <input type="file"
                               accept="image/*"
                               class="form-control @error('profile') is-invalid @enderror"
                               id="profile"
                               name="profile">

                        @error('profile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

             <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email</label>

                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Enter Email">

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <!-- Password -->
            <div class="mb-3">
                <label class="form-label">Password</label>

                <input type="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Enter New Password">

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <small class="text-muted">
                    Leave empty to keep the current password.
                </small>
            </div>


            <!-- Confirm Password -->
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>

                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Confirm New Password">
            </div>


            <!-- Role -->
            <div class="mb-3">
                <label class="form-label">Role</label>

                <select name="role"
                        class="form-select @error('role') is-invalid @enderror">

                    <option value="">Choose Role</option>

                    <option value="User"
                        {{ old('role', $user->role) == 'User' ? 'selected' : '' }}>
                        User
                    </option>

                    <option value="admin"
                        {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                </select>

                @error('role')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

             <!-- Buttons -->
            <div class="mt-3">

                <button type="submit"
                        class="btn btn-primary">
                    Update User
                </button>

                <a href="{{ route('backend.users.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </div>



            </form>
        </div>
    </div>
</div>
@endsection
