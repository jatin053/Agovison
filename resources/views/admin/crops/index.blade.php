@extends('layouts.app')

@php($pageTitle = 'Crop Approval Queue')
@php($pageSubtitle = 'Approve, reject, and monitor all marketplace crop listings.')

@section('content')
    <div class="table-surface">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Crop</th><th>Farmer</th><th>Category</th><th>Status</th><th>Price</th><th></th></tr></thead>
                <tbody>
                    @foreach($crops as $crop)
                        <tr>
                            <td>{{ $crop->title }}</td>
                            <td>{{ $crop->farmer->name }}</td>
                            <td>{{ $crop->category->name }}</td>
                            <td><span class="badge-soft">{{ ucfirst($crop->status) }}</span></td>
                            <td>INR {{ number_format($crop->effective_price, 2) }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.crops.approve', $crop) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-success btn-sm">Approve</button></form>
                                <form action="{{ route('admin.crops.reject', $crop) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-outline-light btn-sm">Reject</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $crops->links() }}</div>
@endsection
