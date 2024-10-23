@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Purchase Order</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="supplier_id">Supplier</label>
            <select class="form-control" name="supplier_id" id="supplier_id" required>
                <option value="">Choose Supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->supplier_no }}">{{ $supplier->supplier_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="item_id">Item</label>
            <select class="form-control" name="item_id" id="item_id" required>
                <option value="">Choose Item</option>
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" name="quantity" required>
        </div>
      
        <div class="form-group">
            <label for="order_date">Order Date</label>
            <input type="date" class="form-control" name="order_date" value="{{date('Y-m-d')}}" readonly>
        </div>
        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="number" class="form-control" name="discount" value="0">
        </div>
        <button type="submit" class="btn btn-primary">Create Order</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('supplier_id').addEventListener('change', function() {
            var supplierId = this.value;
            if (supplierId) {
                fetch('/suppliers/' + supplierId + '/items')
                    .then(response => response.json())
                    .then(data => {
                        const itemSelect = document.getElementById('item_id');
                        itemSelect.innerHTML = '<option value="">Choose Item</option>'; // Reset options
                        data.forEach(item => {
                            itemSelect.innerHTML += `<option value="${item.item_id}">${item.item_name}</option>`;
                        });
                    })
                    .catch(error => console.error('Fetch error: ', error));
            } else {
                document.getElementById('item_id').innerHTML = '<option value="">Choose Item</option>'; // Reset options
            }
        });
    });
</script>

@endsection
