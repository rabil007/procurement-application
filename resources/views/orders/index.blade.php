@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Purchase Orders</h1>
    <div class="mb-3">
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Create Purchase Order</a>
        <a href="javascript:void(0);" class="btn btn-success" onclick="exportToExcel()">Export to Excel</a>
        <a href="javascript:void(0);" class="btn btn-danger" onclick="exportToPDF()">Print PDF</a>
    </div>

    <table class="table table-bordered" id="ordersTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Order No</th>
                <th>Supplier</th>
                <th>Item Name</th>
                <th>Stock Unit</th>
                <th>Unit Price</th>
                <th>Order Qty</th>
                <th>Item Amount</th>
                <th>Discount</th>
                <th>Net Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $key => $order)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $order->order_no }}</td>
                    <td>{{ $order->supplier->supplier_name }}</td>
                    <td>{{ $order->item->item_name }}</td>
                    <td>{{ $order->item->stock_unit }}</td>
                    <td>{{ $order->item->unit_price }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->item->unit_price * $order->quantity }}</td>
                    <td>{{ $order->discount }}</td>
                    <td>{{ $order->net_amount }}</td>
                    <td>
                        <a href="{{ route('orders.edit', $order->order_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('orders.destroy', $order->order_id) }}" method="POST" style="display:inline;">
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

<!-- Excel export library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- Alternative jsPDF and AutoTable libraries -->
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.5.28/dist/jspdf.plugin.autotable.min.js"></script>

<script>
function exportToExcel() {
    const table = document.getElementById("ordersTable");
    const workbook = XLSX.utils.table_to_book(table, { sheet: "Purchase Orders" });
    XLSX.writeFile(workbook, 'purchase_orders.xlsx');
}

function exportToPDF() {
    const { jsPDF } = window.jspdf;  // Get jsPDF instance
    const doc = new jsPDF();  // Initialize PDF document

    doc.text("Purchase Orders", 14, 10);  // Add title
    doc.autoTable({ html: '#ordersTable', startY: 20 });  // Generate table

    doc.save('purchase_orders.pdf');  // Save PDF
}
</script>
@endsection
