<div class="surface-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="invoice-logo d-flex align-items-center gap-3">
            <span class="brand-icon"><i class="fa-solid fa-seedling"></i></span>
            <div>
                <h2 class="mb-0">AgroVision Invoice</h2>
                <small class="muted-label">Invoice #{{ $order->invoice_number }}</small>
            </div>
        </div>
        @unless(!empty($pdfMode))
            <a href="{{ route('buyer.orders.invoice.pdf', $order) }}" class="btn btn-success no-print">Download PDF</a>
        @endunless
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <h5>Bill to</h5>
            <div>{{ $order->shipping_name }}</div>
            <div>{{ $order->shipping_email }}</div>
            <div>{{ $order->shipping_phone }}</div>
            <div>{{ $order->shipping_address }}, {{ $order->shipping_city }}</div>
        </div>
        <div class="col-md-6 text-md-end">
            <div><strong>Order #:</strong> {{ $order->order_number }}</div>
            <div><strong>Payment:</strong> {{ ucfirst($order->payment_status) }}</div>
            <div><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</div>
            <div><strong>Farmer:</strong> {{ $order->farmer->name }}</div>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Crop</th>
                <th>Qty</th>
                <th>Unit Price</th>
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
    <div class="row justify-content-end">
        <div class="col-md-4">
            <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><strong>INR {{ number_format((float) $order->subtotal, 2) }}</strong></div>
            <div class="d-flex justify-content-between mb-2"><span>Tax</span><strong>INR {{ number_format((float) $order->tax, 2) }}</strong></div>
            <div class="d-flex justify-content-between mb-2"><span>Shipping</span><strong>INR {{ number_format((float) $order->shipping_fee, 2) }}</strong></div>
            <div class="d-flex justify-content-between fs-5 mt-3"><span>Total</span><strong>INR {{ number_format((float) $order->total_amount, 2) }}</strong></div>
        </div>
    </div>
</div>
