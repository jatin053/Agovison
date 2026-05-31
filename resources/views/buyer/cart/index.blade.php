@extends('layouts.app')

@php($pageTitle = 'Shopping Cart')
@php($pageSubtitle = 'Review quantities, crop totals, and prepare for checkout.')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="table-surface">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Crop</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $item->crop->primary_image_url }}" alt="{{ $item->crop->title }}" style="width: 64px; height: 64px; object-fit: cover; border-radius: 16px;">
                                            <div>
                                                <div class="fw-semibold">{{ $item->crop->title }}</div>
                                                <small class="muted-label">{{ $item->crop->location }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>INR {{ number_format((float) $item->unit_price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('buyer.cart.update', $item) }}" method="POST" class="d-flex gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" min="1" name="quantity" value="{{ $item->quantity }}" class="form-control" style="max-width: 90px;">
                                            <button class="btn btn-outline-light btn-sm">Update</button>
                                        </form>
                                    </td>
                                    <td class="fw-bold">INR {{ number_format($item->line_total, 2) }}</td>
                                    <td>
                                        <form action="{{ route('buyer.cart.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 muted-label">Your cart is currently empty.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="surface-card">
                <h4 class="mb-3">Order Summary</h4>
                <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><strong>INR {{ number_format($subtotal, 2) }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span>Tax estimate</span><strong>INR {{ number_format($subtotal * 0.05, 2) }}</strong></div>
                <div class="d-flex justify-content-between mb-4"><span>Shipping</span><strong>INR {{ $subtotal > 0 ? '75.00' : '0.00' }}</strong></div>
                <a href="{{ route('buyer.checkout.index') }}" class="btn btn-success w-100 {{ $cartItems->isEmpty() ? 'disabled' : '' }}">Proceed to checkout</a>
            </div>
        </div>
    </div>
@endsection
