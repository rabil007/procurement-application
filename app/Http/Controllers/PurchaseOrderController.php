<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PurchaseOrderController extends Controller
{
   
    public function index()
    {
        $orders = PurchaseOrder::with(['supplier', 'item'])->get();  
        return view('orders.index', compact('orders'));
    }

    

    public function create()
    {
        $suppliers = Supplier::all();
        $items = Item::all();  
        return view('orders.create', compact('suppliers', 'items'));  
    }

    public function getItemsBySupplier($supplierId)
    {
        $items = Item::where('supplier_id', $supplierId)->get();
        return response()->json($items);
    }



    public function store(Request $request)
    {
        \Log::info($request->all());
    
        // Validate incoming request
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_no',
            'item_id' => 'required|exists:item,item_id',  
            'quantity' => 'required|numeric|min:1',
            'discount' => 'nullable|numeric',  
        ]);
    
         
        $item = Item::find($request->item_id);
        // \Log::info($item);
        $item_total = $item->unit_price * $request->quantity;  
        $discount = $request->discount ?? 0;  
        $net_amount = $item_total - $discount;
    
        $order_no = 'PO-' . date('Ymd') . '-' . str_pad((PurchaseOrder::count() + 1), 4, '0', STR_PAD_LEFT);
    
         
        try {
            PurchaseOrder::create([
                'order_no' => $order_no,
                'order_date' => $request->order_date,
                'supplier_id' => $request->supplier_id,
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'item_total' => $item_total,
                'discount' => $discount,
                'net_amount' => $net_amount,
            ]);
        } catch (\Exception $e) {
            // \Log::error('Error creating Purchase Order: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to create Purchase Order. Please try again.');
        }
    
        return redirect()->route('orders.index')->with('success', 'Purchase Order created successfully.');
    }
    

    



    public function edit($id)
    {
        $order = PurchaseOrder::findOrFail($id);
        $suppliers = Supplier::all();
        $items = Item::where('supplier_id', $order->supplier_id)->get(); // Pre-load items for the supplier.

        return view('orders.edit', compact('order', 'suppliers', 'items'));
    }


    public function update(Request $request, $order_id)
    {
        \Log::info($request->all());
    
        // Validate incoming request
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_no',
            'item_id' => 'required|exists:item,item_id',
            'quantity' => 'required|numeric|min:1',
            'discount' => 'nullable|numeric',
        ]);
    
        // Fetch item details to calculate totals
        $item = Item::find($request->item_id);
        $item_total = $item->unit_price * $request->quantity; 
        $discount = $request->discount ?? 0;
        $net_amount = $item_total - $discount;
    
        // Find the order by ID
        $order = PurchaseOrder::findOrFail($order_id);
    
        try {
            $order->update([
                'supplier_id' => $request->supplier_id,
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'item_total' => $item_total,
                'discount' => $discount,
                'net_amount' => $net_amount,
            ]);
        } catch (\Exception $e) {
            // \Log::error('Error updating Purchase Order: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to update Purchase Order. Please try again.');
        }
    
        return redirect()->route('orders.index')->with('success', 'Purchase Order updated successfully.');
    }
    

    public function destroy($order_id)
    {
        $order = PurchaseOrder::findOrFail($order_id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Purchase Order deleted successfully.');
    }
}
