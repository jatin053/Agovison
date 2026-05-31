<x-guest-layout>
    <h2 class="fw-bold mb-3">Verify your email</h2>
    <p class="text-secondary">Thanks for signing up. Please verify your email by clicking the link we sent you.</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn btn-success w-100 mb-3">Resend verification email</button>
    </form>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-outline-light w-100">Logout</button>
    </form>
</x-guest-layout>
