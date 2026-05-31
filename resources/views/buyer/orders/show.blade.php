@extends('layouts.app')

@php($pageTitle = 'Order '.$order->order_number)
@php($pageSubtitle = 'Review line items, farmer details, and payment progress.')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="table-surface">
                <h4 class="mb-3">Order items</h4>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Crop</th>
                                <th>Qty</th>
                                <th>Unit price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->crop->title }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>INR {{ number_format((float) $item->unit_price, 2) }}</td>
                                    <td>INR {{ number_format((float) $item->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="surface-card mb-4">
                <h4 class="mb-3">Summary</h4>
                <div class="d-flex justify-content-between mb-2"><span>Status</span><strong>{{ ucfirst($order->status) }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span>Payment</span><strong>{{ ucfirst($order->payment_status) }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span>Farmer</span><strong>{{ $order->farmer->name }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><strong>INR {{ number_format((float) $order->subtotal, 2) }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span>Tax</span><strong>INR {{ number_format((float) $order->tax, 2) }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span>Shipping</span><strong>INR {{ number_format((float) $order->shipping_fee, 2) }}</strong></div>
                <div class="d-flex justify-content-between fs-5 mt-3"><span>Total</span><strong class="text-success">INR {{ number_format((float) $order->total_amount, 2) }}</strong></div>
            </div>
            <div class="surface-card">
                <h4 class="mb-3">Invoice</h4>
                <a href="{{ route('buyer.orders.invoice', $order) }}" class="btn btn-outline-light w-100 mb-2">Preview invoice</a>
                <a href="{{ route('buyer.orders.invoice.pdf', $order) }}" class="btn btn-success w-100">Download PDF</a>
            </div>
        </div>
    </div>
@endsection
