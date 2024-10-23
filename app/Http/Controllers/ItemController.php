<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('supplier')->get();
        return view('Item.index', compact('items'));
    }


    public function create()
    {
        $suppliers = Supplier::all();
        return view('item.create', compact('suppliers'));
    }

    public function store(Request $request)
{
    $request->validate([
        'item_name' => 'required|string|max:255',
        'inventory_location' => 'required|string|max:255',
        'brand' => 'nullable|string',
        'category' => 'nullable|string',
        'supplier_id' => 'required|exists:suppliers,supplier_no', 
        'stock_unit' => 'required|string',
        'unit_price' => 'required|numeric',
        'item_images' => 'nullable|array',
        'item_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'status' => 'in:Enabled,Disabled',
    ]);

     
    $images = null;
    if ($request->hasFile('item_images')) {
        $imagePaths = [];
        foreach ($request->file('item_images') as $image) {
            $path = $image->store('item_images', 'public');
            $imagePaths[] = $path;
        }
        $images = json_encode($imagePaths);  
    }

    // Create the item and merge the images field if present
    Item::create([
        'item_name' => $request->item_name,
        'inventory_location' => $request->inventory_location,
        'brand' => $request->brand,
        'category' => $request->category,
        'supplier_id' => $request->supplier_id,
        'stock_unit' => $request->stock_unit,
        'unit_price' => $request->unit_price,
        'item_images' => $images,  
        'status' => $request->status,
    ]);

    return redirect()->route('item.index')->with('success', 'Item created successfully.');
}



    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $suppliers = Supplier::all();
        return view('item.edit', compact('item', 'suppliers'));
    }

    public function update(Request $request, $item_id)
{
    $request->validate([
        'item_name' => 'required|string|max:255',
        'inventory_location' => 'required|string|max:255',
        'brand' => 'nullable|string',
        'category' => 'nullable|string',
        'supplier_id' => 'required|exists:suppliers,supplier_no',  
        'stock_unit' => 'required|string',
        'unit_price' => 'required|numeric',
        'item_images' => 'nullable|array',
        'item_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'status' => 'in:Enabled,Disabled',
    ]);

    $item = Item::findOrFail($item_id);

     
    if ($request->hasFile('item_images')) {
        $images = [];
        foreach ($request->file('item_images') as $image) {
            $path = $image->store('item_images', 'public');
            $images[] = $path;
        }
        $request->merge(['item_images' => json_encode($images)]);
    } else {
         
        $request->merge(['item_images' => $item->item_images]);
    }

    $item->update($request->except('item_images'));  

    if ($request->has('item_images')) {
        $item->item_images = $request->item_images;
        $item->save();
    }

    return redirect()->route('item.index')->with('success', 'Item updated successfully.');
}


    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('item.index')->with('success', 'Item deleted successfully.');
    }
}

