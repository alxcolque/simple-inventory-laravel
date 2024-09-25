<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Sale;
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
        /* "clientId" => "2"
        "total" => "342"
        "cart" => array:3 [
            0 => array:5 [
            "id" => "1"
            "name" => "Leche"
            "image" => "http://localhost:8000/images/products/1727189696_66f2d2c062fbd.jpg"
            "price" => "2"
            "quantity" => 1
            ],
            1 => array:5 [
            "id" => "2"
            "name" => "Marillo"
            "image" => null
            "price" => "8"
            "quantity" => 1
            ],
            2 => array:5 [
            "id" => "3"
            "name" => "Para hace el amor"
            "image" => "http://localhost:8000/images/products/1727189838_66f2d34e2c67b.gif"
            "price" => "166"
            "quantity" => 2
            ],
        ] */
        // se tiene Usuario autenticado como seller_id, clientId como client_id y total como total.
        dd($request);
        $cart = $request->cart;
        /* $client = json_decode($request->clientId);
        $total = json_decode($request->total); */
        $sale = Sale::create([
            'seller_id' => Auth::user()->id,
            'client_id' => $request->clientId,
            'total' => $request->total,
            'status' => 'pendiente',
        ]);
        //decode json cart

        // guardar en la tabla detalle de ventas con la venta creada
        foreach ($cart as $item) {
            $detail = new Detail();
            $detail->sale_id = $sale->id;
            $detail->product_id = $item->product_id;
            $detail->qty = $item->quantity;
            $detail->price = $item->price;
            $detail->save();
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

    public function destroy($id)
    {
        $sale = Sale::find($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully');
    }
}
