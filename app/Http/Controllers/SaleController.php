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
        if ($search) {
            // Filtra las compras por el nombre del producto y las guarda en la variable $sales
            $sales = Sale::whereHas('client', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->paginate(10);
        }
        // Filtra por dia, semana, mes o año y las guarda en la variable $sales
        if ($filter) {
            if ($filter == 'day') {
                $sales = Sale::whereDate('created_at', date('Y-m-d'))->paginate(10);
            } else if ($filter == 'week') {
                $sales = Sale::whereBetween('created_at', [date('Y-m-d', strtotime('-1 week')), date('Y-m-d')])->paginate(10);
            } else if ($filter == 'month') {
                $sales = Sale::whereMonth('created_at', date('m'))->paginate(10);
            } else if ($filter == 'year') {
                $sales = Sale::whereYear('created_at', date('Y'))->paginate(10);
            } else {
                $sales = Sale::paginate(10);
            }
        } else {
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
        $productIds = array_column($cart, 'productId');
        // Busca los productos por los id
        $products = Product::whereIn('id', $productIds)->get();
        //valida en la tabla de compras que la cantidad sea menor
        //dd($cart);
        //return;
        foreach ($cart as $item) {
            $product = $products->where('id', $item['productId'])->first();
            // una consulta que sume la columna stock en la tabla purchases del producto en especifico.
            $countStockPurchase = Purchase::where('product_id', $product->id)->sum('stock');
            //$countStockPurchase = Purchase::find($item['purchaseId']);
            if ($item['quantity'] > $countStockPurchase) {
                return response()->json(['message' => 'Stock insuficiente', 'id' => '0'], 400);
            }
        }
        // Valida que los productos existan
        if (count($products) <= 0) {
            return response()->json(['message' => 'Producto no encontrado', 'id' => '0'], 404);
        } else {
            $sale = Sale::create([
                'seller_id' => Auth::user()->id,
                'client_id' => $request->clientId,
                'iva' => $request->ivaTotal,
                'total' => $request->total,
                'status' => 'pendiente',
            ]);

            foreach ($cart as $item) {
                //Cardex actualiza el stock y balance
                $currentStock = Product::find($item['productId'])->stock(); //2170
                // actualiza la columna stock de compras con la cantidad de productos vendidos.
                $purchase = Purchase::where('product_id', $item['productId'])->where('stock', '>', 0)->get();
                $strCostUnit = '';
                $balanceSale = 0;
                $currentQuantity = $item['quantity']; //1280
                $currentBalance = 0;
                foreach ($purchase as $p) {
                    if ($currentQuantity <= $p->stock) { //1280 <= 850
                        $currentBalance = $p->balance;
                        $balanceSale = $balanceSale + ($currentQuantity * $p->price); //0 + (430 * 24.36) = 10474.8
                        $currentQuantity = $p->qty - $currentQuantity; //1280 - 430 = 890
                        $strCostUnit = $strCostUnit . $p->price; //0 + 24.36 = 24.36
                        $p->stock =  $p->stock - $item['quantity']; //850 - 430 = 420
                        $p->save();
                        //salirse del foreach
                        break;
                    } else if ($currentQuantity <= $currentStock) { //1280 <= 2170
                        $currentBalance = $p->balance;
                        $currentQuantity = $currentQuantity - $p->stock; //1280 - 850 = 430
                        $balanceSale = $balanceSale + ($p->stock * $p->price); //0 + (850 * 25) = 21250
                        $strCostUnit = $strCostUnit . $p->price . '|'; //10 + 25 = 10|25
                        $p->stock = $p->qty - $p->stock; //850 - 850 = 0
                        $p->save();
                    } else {
                        return response()->json(['message' => 'Stock insuficiente', 'id' => '0'], 400);
                    }
                }
                // guarda el detalle de la venta

                $detail = new Detail();
                $detail->sale_id = $sale->id;
                $detail->product_id = $item['productId'];
                $detail->qty = $item['quantity'];
                $detail->price = $item['price'];
                $detail->unit = $item['unit'];
                $detail->save();

                // actualiza el kardex
                $qtyProductEntry = Product::find($item['productId'])->currentProductEntry();
                $qtyProductExit = Product::find($item['productId'])->currentProductExit();
                $productStock = $qtyProductEntry - $qtyProductExit - $item['quantity'];
                $sumAmountEntry = Product::find($item['productId'])->currentEntry();
                $sumAmountExit = Product::find($item['productId'])->currentExit();
                $totalAmount = $sumAmountEntry - $sumAmountExit - $balanceSale;

                $kardex = [];
                $kardex['product_id'] = $item['productId'];
                $kardex['operation_date'] = $detail->created_at;
                $kardex['detail'] = 'Venta';
                $kardex['product_exit'] = $item['quantity'];
                $kardex['product_stock'] = $productStock;
                $kardex['cost_unit'] = $strCostUnit;
                $kardex['amount_exit'] = $balanceSale;
                $kardex['amount_stock'] = $totalAmount;
                KardexController::kardeStore($kardex);
            }
            return response()->json(['message' => 'Venta registrado con éxito', 'id' => $sale->id], 200);
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
        return redirect()->route('sales.index')->with('success', 'Venta actualizada exitosamente');
    }

    public function show($id)
    {
        $sale = Sale::find($id);
        $detail = Detail::where('sale_id', $id)->get();
        return view('sales.show', compact('sale', 'detail'));
    }

    public function destroy($id)
    {
        $sale = Sale::find($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Venta eliminada exitosamente');
    }
}
