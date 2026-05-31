<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="fw-bold">Welcome back</h2>
        <p class="text-secondary mb-0">Sign in to your AgroVision AI dashboard for crops, weather, marketplace, and smart farming insights.</p>
    </div>

    <div class="auth-social-grid">
        <button type="button" class="btn btn-outline-light"><i class="fa-brands fa-google me-2"></i>Google</button>
        <button type="button" class="btn btn-outline-light"><i class="fa-brands fa-apple me-2"></i>Apple</button>
    </div>

    <div class="auth-divider">or continue with email</div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Remember me</label>
            </div>
            <a href="{{ route('password.request') }}" class="text-success text-decoration-none">Forgot password?</a>
        </div>
        <button class="btn btn-success w-100">Login</button>
        <div class="text-center mt-3 text-secondary">
            New to AgroVision AI? <a href="{{ route('register') }}" class="text-success text-decoration-none">Create account</a>
        </div>
    </form>
</x-guest-layout>
