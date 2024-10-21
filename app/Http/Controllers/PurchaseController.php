<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $search = $request->get('search');
        if($request->get('category')){
            // Filtra las compras por la categoria seleccionada y las guarda en la variable $purchases
            $purchases = Purchase::whereHas('product', function($query) use ($request){
                $query->where('category_id', $request->get('category'));
            })->paginate(10);
        }else if($search){
            // Filtra las compras por el nombre del producto y las guarda en la variable $purchases
            $purchases = Purchase::whereHas('product', function($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            })->paginate(10);
        }else{
            // Filtra por dia, semana, mes o año y las guarda en la variable $purchases
            if($filter){
                if($filter == 'day'){
                    $purchases = Purchase::whereDate('created_at', date('Y-m-d'))->paginate(10);
                }else if($filter == 'week'){
                    $purchases = Purchase::whereBetween('created_at', [date('Y-m-d', strtotime('-1 week')), date('Y-m-d')])->paginate(10);
                }else if($filter == 'month'){
                    $purchases = Purchase::whereMonth('created_at', date('m'))->paginate(10);
                }else if($filter == 'year'){
                    $purchases = Purchase::whereYear('created_at', date('Y'))->paginate(10);
                }else{
                    $purchases = Purchase::paginate(10);
                }
            }else{
                $purchases = Purchase::paginate(10);
            }
        }
        $allPurchases = Purchase::all();
        $categoryInPurchases = Product::whereIn('id', $allPurchases->pluck('product_id'))->pluck('category_id', 'id')->unique();
        $categories = Category::whereIn('id', $categoryInPurchases->values())->get();
        $total_compras = 0;
        $total_beneficio = 0;
        foreach($purchases as $purchase){
            $total_compras += $purchase->price * $purchase->qty;
            $total_beneficio += $purchase->revenue * $purchase->qty;
        }
        return view('purchases.index', compact('purchases', 'search', 'categories', 'filter','total_compras','total_beneficio'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('purchases.create', compact('products','suppliers'));
    }

    public function store(PurchaseRequest $request)
    {
        //dd($request->iva);
        //return;
        // si existe el producto solo se debe actualizar el stock y la cantidad
        /*$existProductoInPurchase = Purchase::where('product_id', $request->product_id)->first();
        if($existProductoInPurchase){
            $newQty = $request->qty + $existProductoInPurchase->qty;
            $existProductoInPurchase->qty = $newQty;
            $existProductoInPurchase->price = $request->price;
            $existProductoInPurchase->revenue = ($request->price_sale * $request->price) / 100;
            $existProductoInPurchase->iva = $request->iva;
            $existProductoInPurchase->stock = $newQty;
            $existProductoInPurchase->supplier_id = $request->supplier_id;
            $existProductoInPurchase->unit = $request->unit;
            $existProductoInPurchase->expiration_date = $request->expiration_date;
            $existProductoInPurchase->save();
            return redirect()->route('purchases.index')->with('success', 'Se añadió '. $request->qty .' productos a la compra');
        }*/
        $purchase = $request->all();
        //return;

        $currentStock = Product::find($request->product_id)->stock();
        $currentBalance = Product::find($request->product_id)->balance();
        if($request->iva== 0){
            $purchase['iva'] = true;
        }
        $revenue = ($request->price_sale * $request->price) / 100;
        $purchase['revenue'] = $revenue;
        $purchase['stock'] = $currentStock + $request->qty;
        $purchase['balance'] = $currentBalance + ($request->price * $request->qty);
        $newPurchase = Purchase::create($purchase);

        $kardex = [];
        $kardex['product_id'] = $newPurchase->product_id;
        $kardex['operation_date'] = $newPurchase->created_at;
        $kardex['detail'] = 'Compra '.$request->comment;
        $kardex['product_entry'] = $request->qty;
        $kardex['product_stock'] = $currentStock + $request->qty;
        $kardex['cost_unit'] = $purchase['price'];
        $kardex['amount_entry'] = $purchase['price'] * $purchase['qty'];
        $kardex['amount_stock'] = ($purchase['price'] * $purchase['qty']) + ($currentBalance);
        KardexController::kardeStore($kardex);

        return redirect()->route('purchases.index')->with('success', 'Compra creada exitosamente');
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
        $purchase->stock = $request->qty;
        $purchase->iva = $request->iva;
        $purchase->revenue = ($request->price_sale * $request->price) / 100;
        $purchase->unit = $request->unit;
        $purchase->expiration_date = $request->expiration_date;
        $purchase->save();
        return redirect()->route('purchases.index')->with('success', 'Compra actualizada exitosamente');
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
        return redirect()->route('purchases.index')->with('success', 'Compra eliminada exitosamente');
    }
}
