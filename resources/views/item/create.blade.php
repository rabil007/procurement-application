@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Inventory Item</h1>
    <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="item_name">Item Name</label>
            <input type="text" class="form-control" name="item_name" required>
        </div>
        <div class="form-group">
            <label for="inventory_location">Inventory Location</label>
            <input type="text" class="form-control" name="inventory_location" required>
        </div>
        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" class="form-control" name="brand">
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" class="form-control" name="category">
        </div>
        <div class="form-group">
            <label for="supplier_id">Supplier</label>
            <select class="form-control" name="supplier_id" required>
                <!-- Add your supplier options here -->
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->supplier_no }}">{{ $supplier->supplier_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="stock_unit">Stock Unit</label>
            <input type="text" class="form-control" name="stock_unit" required>
        </div>
        <div class="form-group">
            <label for="unit_price">Unit Price</label>
            <input type="number" class="form-control" name="unit_price" required>
        </div>
        <div class="form-group">
            <label for="item_images">Item Images</label>
            <input type="file" class="form-control" name="item_images[]" multiple>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status">
                <option value="Enabled" selected>Enabled</option>
                <option value="Disabled">Disabled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
