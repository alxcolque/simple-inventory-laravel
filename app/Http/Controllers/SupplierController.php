<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $suppliers = Supplier::where('full_name', 'like', '%'.$search.'%')->paginate(10);
        return view('suppliers.index', compact('suppliers','search'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(SupplierRequest $request)
    {
        $supplier = Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Proveedor creado correctamente');
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, $id)
    {
        $supplier = Supplier::find($id);
        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Proveedor actualizado correctamente');
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Proveedor eliminado correctamente');
    }
}
