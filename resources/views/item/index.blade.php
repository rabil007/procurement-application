@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventory Items</h1>
    <a href="{{ route('item.create') }}" class="btn btn-primary mb-3 float-right">Add Item</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item No</th>
                <th>Item Name</th>
                <th>Inventory Location</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Supplier</th>
                <th>Stock Unit</th>
                <th>Unit Price</th>
                <th>Status</th>
                <th>Images</th>
                <th >Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $key => $item)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->inventory_location }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->category }}</td>
                    <td>
                        {{ $item->supplier ? $item->supplier->supplier_name : 'No Supplier' }}
                    </td>
                    <td>{{ $item->stock_unit }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        @if ($item->item_images)
                            @php
                                $images = json_decode($item->item_images, true);
                            @endphp
                            @foreach ($images as $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="Item Image" width="50">
                            @endforeach
                        @else
                            No Images
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('item.edit', $item->item_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('item.destroy', $item->item_id) }}" method="POST" style="display:inline;">
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
