@extends('layouts.app')

@php($pageTitle = 'Admin Command Center')
@php($pageSubtitle = 'Track revenue, auctions, growth loops, approvals, and platform-wide activity from one premium dashboard.')

@section('content')
    <div class="row g-4 mb-4">
        @foreach($analytics['totals'] as $label => $value)
            <div class="col-md-6 col-xl-3">
                <div class="metric-card">
                    <h6>{{ str_replace('_', ' ', ucfirst($label)) }}</h6>
                    <div class="metric-value" data-countup="{{ (int) $value }}" @if($label === 'revenue') data-countup-format="currency" @endif>
                        {{ is_numeric($value) ? number_format($value, 2) : $value }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-7">
            <div class="surface-card chart-card">
                <h4 class="mb-4">Monthly sales</h4>
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="surface-card chart-card">
                <h4 class="mb-4">Auction activity</h4>
                <canvas id="auctionChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-6">
            <div class="table-surface">
                <h4 class="mb-3">Pending crop approvals</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>Crop</th><th>Farmer</th><th>Category</th><th></th></tr></thead>
                        <tbody>
                            @forelse($pendingCrops as $crop)
                                <tr>
                                    <td>{{ $crop->title }}</td>
                                    <td>{{ $crop->farmer->name }}</td>
                                    <td>{{ $crop->category->name }}</td>
                                    <td class="text-end">
                                        <form class="d-inline" method="POST" action="{{ route('admin.crops.approve', $crop) }}">@csrf @method('PATCH')<button class="btn btn-success btn-sm">Approve</button></form>
                                        <form class="d-inline" method="POST" action="{{ route('admin.crops.reject', $crop) }}">@csrf @method('PATCH')<button class="btn btn-outline-light btn-sm">Reject</button></form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center muted-label">No pending crops.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="table-surface">
                <h4 class="mb-3">Recent orders</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>Order</th><th>Buyer</th><th>Status</th><th>Total</th></tr></thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->buyer->name }}</td>
                                    <td><span class="badge-soft">{{ ucfirst($order->status) }}</span></td>
                                    <td>INR {{ number_format((float) $order->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center muted-label">No recent orders.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-xl-6">
            <div class="surface-card">
                <h4 class="mb-3">Community pulse</h4>
                <div class="metric-stack">
                    @foreach($communityPulse as $post)
                        <div class="mini-card">
                            <div class="muted-label">{{ $post->user->name }}</div>
                            <strong>{{ $post->title ?: 'Field update' }}</strong>
                            <div class="small mt-2">{{ $post->likes_count }} likes • {{ $post->all_comments_count }} comments</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="surface-card">
                <h4 class="mb-3">Active auctions</h4>
                <div class="metric-stack">
                    @foreach($activeAuctions as $auction)
                        <div class="mini-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $auction->title }}</strong>
                                    <div class="small muted-label mt-2">{{ $auction->farmer->name }} • {{ $auction->crop->title }}</div>
                                </div>
                                <div class="text-end">
                                    <div class="small muted-label">{{ $auction->bids_count }} bids</div>
                                    <div class="small mt-2">INR {{ number_format($auction->current_price, 0) }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: @json($analytics['monthly_sales']['labels']),
                datasets: [{ label: 'Revenue', data: @json($analytics['monthly_sales']['values']), borderColor: '#69e084', backgroundColor: 'rgba(105,224,132,.2)', fill: true, tension: 0.35 }]
            }
        });
        new Chart(document.getElementById('auctionChart'), {
            type: 'line',
            data: {
                labels: @json($analytics['auction_activity']['labels']),
                datasets: [{ label: 'Auction launches', data: @json($analytics['auction_activity']['values']), borderColor: '#81c784', backgroundColor: 'rgba(129,199,132,.18)', fill: true, tension: 0.35 }]
            }
        });
    </script>
@endpush
