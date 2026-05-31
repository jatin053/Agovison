@extends('layouts.app')

@php($pageTitle = 'Profile Settings')
@php($pageSubtitle = 'Update your identity, contact details, password, and account preferences.')

@section('content')
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="surface-card">
                <h4 class="mb-3">Profile information</h4>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full name</label>
                            <input class="form-control" name="name" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input class="form-control" name="email" type="email" value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Avatar</label>
                            <input class="form-control" name="avatar" type="file">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input class="form-control" name="city" value="{{ old('city', $user->city) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <input class="form-control" name="state" value="{{ old('state', $user->state) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input class="form-control" name="country" value="{{ old('country', $user->country) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input class="form-control" name="address" value="{{ old('address', $user->address) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control" rows="4" name="bio">{{ old('bio', $user->bio) }}</textarea>
                        </div>
                    </div>
                    <button class="btn btn-success mt-4">Save profile</button>
                </form>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="surface-card mb-4">
                <h4 class="mb-3">Change password</h4>
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Current password</label>
                        <input class="form-control" name="current_password" type="password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New password</label>
                        <input class="form-control" name="password" type="password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm password</label>
                        <input class="form-control" name="password_confirmation" type="password">
                    </div>
                    <button class="btn btn-outline-light w-100">Update password</button>
                </form>
            </div>
            <div class="surface-card">
                <h4 class="mb-3 text-danger">Delete account</h4>
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label class="form-label">Current password</label>
                        <input class="form-control" name="password" type="password">
                    </div>
                    <button class="btn btn-danger w-100">Delete account</button>
                </form>
            </div>
        </div>
    </div>
@endsection
