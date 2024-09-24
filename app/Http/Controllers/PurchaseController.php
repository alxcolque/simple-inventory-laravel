<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->get('search');
        if($request->get('category')){
            $products = Product::where('category_id', $request->get('category'))->paginate(10);
        }else{

            $products = Product::where('name', 'like', '%'.$search.'%')->paginate(10);
        }
        // Filtra todas las categorias de la realcion de productos y las guarda en la variable $categories
        $categories = Product::all()->pluck('category')->unique();

        $purchases = Purchase::paginate(10);
        return view('purchases.index', compact('purchases', 'search', 'categories'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('purchases.create', compact('products','suppliers'));
    }

    public function store(PurchaseRequest $request)
    {
        $purchase = $request->all();
        $purchase['revenue'] = $request->price_sale - $request->price;
        Purchase::create($purchase);
        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully');
    }

    public function edit($id)
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        $purchase = Purchase::find($id);
        return view('purchases.edit', compact('purchase','suppliers','products'));
    }

    public function update(PurchaseRequest $request, $id)
    {
        $purchase = Purchase::find($id);
        $purchase->supplier_id = $request->supplier_id;
        $purchase->product_id = $request->product_id;
        $purchase->price = $request->price;
        $purchase->qty = $request->qty;
        $purchase->revenue = $request->price_sale - $request->price;
        $purchase->save();
        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully');
    }
    // show method
    public function show($id)
    {
        $purchase = Purchase::find($id);
        return view('purchases.show', compact('purchase'));
    }
    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully');
    }
}
