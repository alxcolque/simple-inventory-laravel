<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
        // Calcula el total de ventas.
        $total_ventas = Sale::sum('total');

        foreach($purchases as $purchase){
            $total_compras += $purchase->price * $purchase->qty;
            $total_beneficio += $purchase->revenue * $purchase->qty;
        }
        $clients = Client::all();
        return view('home', compact('purchases', 'search', 'categories', 'filter','total_compras','total_beneficio','total_ventas','clients'));
    }
}
