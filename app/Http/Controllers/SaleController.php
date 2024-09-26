<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $search = $request->get('search');
        if($search){
            // Filtra las compras por el nombre del producto y las guarda en la variable $sales
            $sales = Sale::whereHas('client', function($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            })->paginate(10);
        }
        // Filtra por dia, semana, mes o año y las guarda en la variable $sales
        if($filter){
            if($filter == 'day'){
                $sales = Sale::whereDate('created_at', date('Y-m-d'))->paginate(10);
            }else if($filter == 'week'){
                $sales = Sale::whereBetween('created_at', [date('Y-m-d', strtotime('-1 week')), date('Y-m-d')])->paginate(10);
            }else if($filter == 'month'){
                $sales = Sale::whereMonth('created_at', date('m'))->paginate(10);
            }else if($filter == 'year'){
                $sales = Sale::whereYear('created_at', date('Y'))->paginate(10);
            }else{
                $sales = Sale::paginate(10);
            }
        }else{
            $sales = Sale::paginate(10);
        }
        return view('sales.index', compact('sales', 'search', 'filter'));
    }

    public function create()
    {
        return view('sales.create');
    }

    public function store(Request $request)
    {
        $cart = $request->cart;
        // de cart fitra en un arreglo los id
        $productIds = array_column($cart, 'id');
        // Busca los productos por los id
        $products = Product::whereIn('id', $productIds)->get();
        //valida en la tabla de compras que la cantidad sea menor
        foreach ($cart as $item) {
            $product = $products->where('id', $item['id'])->first();
            // una consulta que sume la columna stock en la tabla purchases del producto en especifico.
            $countStockPurchase = Purchase::where('product_id', $product->id)->sum('stock');
            if($countStockPurchase < $item['quantity']){
                return response()->json(['message' => 'Stock insuficiente', 'id'=>'0'], 400);
            }
        }
        // Valida que los productos existan
        if(count($products) != count($cart)){
            return response()->json(['message' => 'Producto no encontrado', 'id'=>'0'], 404);
        }else{
            $sale = Sale::create([
                'seller_id' => Auth::user()->id,
                'client_id' => $request->clientId,
                'total' => $request->total,
                'status' => 'pendiente',
            ]);
            foreach ($cart as $item) {
                $detail = new Detail();
                $detail->sale_id = $sale->id;
                $detail->product_id = $item['id'];
                $detail->qty = $item['quantity'];
                $detail->price = $item['price'];
                $detail->save();
                // actualiza la columna stock de compras con la cantidad de productos vendidos.
                $purchase = Purchase::where('product_id', $item['id'])->first();
                //$purchase->stock = $purchase->stock - $item['quantity'];
                $purchase->stock = $purchase->stock - $item['quantity'];

                $purchase->save();

            }
            return response()->json(['message' => 'Venta registrado con éxito', 'id'=>$sale->id], 200);
        }
    }
    public function edit($id)
    {
        $sale = Sale::find($id);
        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::find($id);
        $sale->update($request->all());
        return redirect()->route('sales.index')->with('success', 'Sale updated successfully');
    }

    public function show($id){
        $sale = Sale::find($id);
        $detail = Detail::where('sale_id', $id)->get();
        return view('sales.show', compact('sale', 'detail'));
    }

    public function destroy($id)
    {
        $sale = Sale::find($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully');
    }
}
