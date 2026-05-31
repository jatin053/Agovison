@extends('layouts.app')

@php($pageTitle = 'My Orders')
@php($pageSubtitle = 'Track payment status, delivery progress, and download invoices.')

@section('content')
    <div class="table-surface">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Farmer</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_number }}</strong>
                                <div class="muted-label small">{{ $order->invoice_number }}</div>
                            </td>
                            <td>{{ $order->farmer->name }}</td>
                            <td><span class="badge-soft">{{ ucfirst($order->status) }}</span></td>
                            <td>{{ ucfirst($order->payment_status) }}</td>
                            <td class="fw-bold">INR {{ number_format((float) $order->total_amount, 2) }}</td>
                            <td class="text-end">
                                <a href="{{ route('buyer.orders.show', $order) }}" class="btn btn-outline-light btn-sm">View</a>
                                <a href="{{ route('buyer.orders.invoice', $order) }}" class="btn btn-success btn-sm">Invoice</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 muted-label">No orders found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
@endsection
