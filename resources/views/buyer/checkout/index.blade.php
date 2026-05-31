@extends('layouts.app')

@php($pageTitle = 'Checkout')
@php($pageSubtitle = 'Finalize shipping information and simulate Razorpay payment.')

@section('content')
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="surface-card">
                <h4 class="mb-3">Shipping details</h4>
                <form action="{{ route('buyer.checkout.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full name</label>
                            <input class="form-control" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input class="form-control" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input class="form-control" name="shipping_email" value="{{ old('shipping_email', auth()->user()->email) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment method</label>
                            <select class="form-select" name="payment_method">
                                <option value="razorpay_demo">Razorpay Demo</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <input class="form-control" name="shipping_address" value="{{ old('shipping_address', auth()->user()->address) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input class="form-control" name="shipping_city" value="{{ old('shipping_city', auth()->user()->city) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input class="form-control" name="shipping_state" value="{{ old('shipping_state', auth()->user()->state) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Country</label>
                            <input class="form-control" name="shipping_country" value="{{ old('shipping_country', auth()->user()->country ?? 'India') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Zipcode</label>
                            <input class="form-control" name="shipping_zipcode" value="{{ old('shipping_zipcode') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Demo transaction ID</label>
                            <input class="form-control" name="transaction_id" value="{{ old('transaction_id', 'demo_txn_'.\Illuminate\Support\Str::random(8)) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" rows="3" name="notes">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    <button class="btn btn-success mt-4 w-100">Place order</button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="surface-card">
                <h4 class="mb-3">Summary</h4>
                @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between {{ !$loop->last ? 'mb-2' : '' }}">
                        <span>{{ $item->crop->title }} × {{ $item->quantity }}</span>
                        <strong>INR {{ number_format($item->line_total, 2) }}</strong>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><strong>INR {{ number_format($subtotal, 2) }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span>Tax</span><strong>INR {{ number_format($tax, 2) }}</strong></div>
                <div class="d-flex justify-content-between mb-4"><span>Shipping</span><strong>INR {{ number_format($shipping, 2) }}</strong></div>
                <div class="d-flex justify-content-between fs-5"><span>Total</span><strong class="text-success">INR {{ number_format($subtotal + $tax + $shipping, 2) }}</strong></div>
            </div>
        </div>
    </div>
@endsection
