<x-guest-layout>
    <h2 class="fw-bold mb-3">Reset your password</h2>
    <p class="text-secondary">Enter your email address and we will send you a reset link.</p>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>
        <button class="btn btn-success w-100">Send reset link</button>
    </form>
</x-guest-layout>
