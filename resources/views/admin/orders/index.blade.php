@extends('layouts.app')

@php($pageTitle = 'Order Administration')
@php($pageSubtitle = 'Track payment flow, adjust order status, and export marketplace records.')

@section('content')
    <div class="surface-card mb-4">
        <a href="{{ route('admin.orders.export') }}" class="btn btn-success btn-sm">Export Excel</a>
    </div>
    <div class="table-surface">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Order</th><th>Buyer</th><th>Farmer</th><th>Status</th><th>Payment</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->buyer->name }}</td>
                            <td>{{ $order->farmer->name }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ ucfirst($order->payment_status) }}</td>
                            <td>INR {{ number_format((float) $order->total_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
@endsection
