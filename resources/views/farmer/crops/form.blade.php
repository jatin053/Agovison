@extends('layouts.app')

@php($pageTitle = $crop->exists ? 'Edit Crop' : 'Add Crop')
@php($pageSubtitle = 'Maintain pricing, stock, descriptions, and crop images for marketplace approval.')

@section('content')
    <div class="surface-card">
        <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($method !== 'POST')
                @method($method)
            @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input class="form-control" name="title" value="{{ old('title', $crop->title) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category_id">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $crop->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label">Price</label><input class="form-control" name="price" value="{{ old('price', $crop->price) }}"></div>
                <div class="col-md-4"><label class="form-label">Sale Price</label><input class="form-control" name="sale_price" value="{{ old('sale_price', $crop->sale_price) }}"></div>
                <div class="col-md-4"><label class="form-label">Stock</label><input class="form-control" name="stock" value="{{ old('stock', $crop->stock) }}"></div>
                <div class="col-md-6"><label class="form-label">Unit</label><input class="form-control" name="unit" value="{{ old('unit', $crop->unit ?: 'kg') }}"></div>
                <div class="col-md-6"><label class="form-label">Location</label><input class="form-control" name="location" value="{{ old('location', $crop->location) }}"></div>
                <div class="col-md-6"><label class="form-label">Harvest Date</label><input class="form-control" type="date" name="harvest_date" value="{{ old('harvest_date', optional($crop->harvest_date)->format('Y-m-d')) }}"></div>
                <div class="col-md-6"><label class="form-label">Images</label><input class="form-control" type="file" name="images[]" multiple></div>
                <div class="col-12"><label class="form-label">Short Description</label><textarea class="form-control" rows="2" name="short_description">{{ old('short_description', $crop->short_description) }}</textarea></div>
                <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" rows="5" name="description">{{ old('description', $crop->description) }}</textarea></div>
            </div>
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" value="1" name="organic" id="organicCheck" @checked(old('organic', $crop->organic))>
                <label class="form-check-label" for="organicCheck">Organic produce</label>
            </div>
            <button class="btn btn-success mt-4">Save crop</button>
        </form>
    </div>
@endsection
