@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Purchase Order</h1>
    <form action="{{ route('orders.update', $order->order_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="supplier_id">Supplier</label>
            <select class="form-control" name="supplier_id" id="supplier_id" required>
                <option value="">Choose Supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->supplier_no }}" 
                        {{ $supplier->supplier_no == $order->supplier_id ? 'selected' : '' }}>
                        {{ $supplier->supplier_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="item_id">Item</label>
            <select class="form-control" name="item_id" id="item_id" required>
                <option value="">Choose Item</option>
                @foreach ($items as $item)
                    <option value="{{ $item->item_id }}" 
                        {{ $item->item_id == $order->item_id ? 'selected' : '' }}>
                        {{ $item->item_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" name="quantity" value="{{ $order->quantity }}" required>
        </div>

        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="number" class="form-control" name="discount" value="{{ $order->discount }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Order</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const supplierSelect = document.getElementById('supplier_id');
        const itemSelect = document.getElementById('item_id');

        function fetchItems(supplierId, selectedItemId = null) {
            if (supplierId) {
                fetch('/suppliers/' + supplierId + '/items')
                    .then(response => response.json())
                    .then(data => {
                        itemSelect.innerHTML = '<option value="">Choose Item</option>'; // Reset options
                        data.forEach(item => {
                            const isSelected = item.item_id == selectedItemId ? 'selected' : '';
                            itemSelect.innerHTML += `<option value="${item.item_id}" ${isSelected}>${item.item_name}</option>`;
                        });
                    })
                    .catch(error => console.error('Fetch error:', error));
            } else {
                itemSelect.innerHTML = '<option value="">Choose Item</option>'; // Reset options
            }
        }

        // On page load, fetch items for the selected supplier.
        fetchItems(supplierSelect.value, '{{ $order->item_id }}');

        // Update items dynamically when supplier is changed.
        supplierSelect.addEventListener('change', function() {
            fetchItems(this.value);
        });
    });
</script>

@endsection
