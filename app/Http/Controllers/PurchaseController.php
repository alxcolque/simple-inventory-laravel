<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::all();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        return view('purchases.create');
    }

    public function store(Request $request)
    {
        $purchase = Purchase::create($request->all());
        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully');
    }

    public function edit($id)
    {
        $purchase = Purchase::find($id);
        return view('purchases.edit', compact('purchase'));
    }

    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);
        $purchase->update($request->all());
        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully');
    }

    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully');
    }
}
