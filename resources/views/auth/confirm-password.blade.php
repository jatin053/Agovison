<x-guest-layout>
    <h2 class="fw-bold mb-3">Confirm password</h2>
    <p class="text-secondary">Please confirm your password before continuing.</p>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-success w-100">Confirm</button>
    </form>
</x-guest-layout>
