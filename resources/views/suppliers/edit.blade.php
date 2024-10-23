@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Supplier</h1>
    <form action="{{ route('suppliers.update', $supplier->supplier_no) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="supplier_name">Supplier Name</label>
            <input type="text" class="form-control" name="supplier_name" value="{{ $supplier->supplier_name }}" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" value="{{ $supplier->address }}">
        </div>
        <div class="form-group">
            <label for="tax_no">TAX No</label>
            <input type="text" class="form-control" name="tax_no" value="{{ $supplier->tax_no }}">
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" class="form-control" name="country" value="{{ $supplier->country }}" required>
        </div>
        <div class="form-group">
            <label for="mobile_no">Mobile No</label>
            <input type="text" class="form-control" name="mobile_no" value="{{ $supplier->mobile_no }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $supplier->email }}" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status">
                <option value="Active" {{ $supplier->status == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ $supplier->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="Blocked" {{ $supplier->status == 'Blocked' ? 'selected' : '' }}>Blocked</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
