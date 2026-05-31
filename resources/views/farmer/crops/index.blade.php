@extends('layouts.app')

@php($pageTitle = 'Crop Inventory')
@php($pageSubtitle = 'Create, edit, and track the approval state of your crop listings.')

@section('content')
    <div class="surface-card mb-4">
        <a href="{{ route('farmer.crops.create') }}" class="btn btn-success">Add new crop</a>
    </div>
    <div class="table-surface">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Crop</th><th>Category</th><th>Status</th><th>Stock</th><th>Price</th><th></th></tr></thead>
                <tbody>
                    @foreach($crops as $crop)
                        <tr>
                            <td>{{ $crop->title }}</td>
                            <td>{{ $crop->category->name }}</td>
                            <td><span class="badge-soft">{{ ucfirst($crop->status) }}</span></td>
                            <td>{{ $crop->stock }} {{ $crop->unit }}</td>
                            <td>INR {{ number_format($crop->effective_price, 2) }}</td>
                            <td class="text-end">
                                <a href="{{ route('farmer.crops.edit', $crop) }}" class="btn btn-outline-light btn-sm">Edit</a>
                                <form action="{{ route('farmer.crops.destroy', $crop) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $crops->links() }}</div>
@endsection
