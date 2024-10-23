<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();  
        return view('suppliers.index', compact('suppliers'));  
    }


    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'tax_no' => 'nullable|string',
            'country' => 'required|string',
            'mobile_no' => 'nullable|string|max:15',
            'email' => 'required|email|unique:suppliers,email',
            'status' => 'in:Active,Inactive,Blocked',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id); // Fetch the supplier or throw a 404
        return view('suppliers.edit', compact('supplier')); // Return the edit view
    }
    

    public function update(Request $request, $supplier_no)
    {
        // Validate the request data
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'tax_no' => 'nullable|string',
            'country' => 'required|string',
            'mobile_no' => 'nullable|string|max:15',
            'email' => 'required|email|unique:suppliers,email,' . $supplier_no . ',supplier_no', // Reference to supplier_no
            'status' => 'in:Active,Inactive,Blocked',
        ]);

        
        $supplier = Supplier::where('supplier_no', $supplier_no)->firstOrFail();

         
        $supplier->update($request->all());

         
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }


    public function destroy($id)
    {
        $supplier = Supplier::findOrFail(id: $id);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}

