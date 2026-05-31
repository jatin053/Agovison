<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="fw-bold">Create your AgroVision AI account</h2>
        <p class="text-secondary mb-0">Register as a farmer, buyer, or expert and join the smart agriculture ecosystem.</p>
    </div>

    <div class="auth-social-grid">
        <button type="button" class="btn btn-outline-light"><i class="fa-brands fa-google me-2"></i>Google</button>
        <button type="button" class="btn btn-outline-light"><i class="fa-brands fa-linkedin me-2"></i>LinkedIn</button>
    </div>

    <div class="auth-divider">or create with email</div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Full name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>
        <button class="btn btn-success w-100 mt-4">Create account</button>
        <div class="text-center mt-3 text-secondary">
            Already registered? <a href="{{ route('login') }}" class="text-success text-decoration-none">Sign in</a>
        </div>
    </form>
</x-guest-layout>
