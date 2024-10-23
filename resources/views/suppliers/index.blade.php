@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Suppliers</h1>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3 float-right">Add Supplier</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Supplier No</th>
                <th>Supplier Name</th>
                <th>Address</th>
                <th>TAX No</th>
                <th>Country</th>
                <th>Mobile No</th>
                <th>Email</th>
                <th>Status</th>
                <th class="w-25">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $key=> $supplier)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $supplier->supplier_name }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>{{ $supplier->tax_no }}</td>
                    <td>{{ $supplier->country }}</td>
                    <td>{{ $supplier->mobile_no }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->status }}</td>
                    <td>
                        <a href="{{ route('suppliers.edit', $supplier->supplier_no) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('suppliers.destroy', $supplier->supplier_no) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
