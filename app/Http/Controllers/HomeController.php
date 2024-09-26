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

        $total_ventas = 0;
        $total_compras = 0;
        $total_beneficio = 0;
        // Calcula el total de ventas.
        $total_ventas = Sale::sum('total');
        // Ventas por categorias
        $categories_sales = Sale::selectRaw('categories.title as name, categories.color, sum(sales.total) as total')
            ->join('details', 'details.sale_id', '=', 'sales.id')
            ->join('products', 'products.id', '=', 'details.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->groupBy('categories.title','categories.color')
            ->get();

        // calcula total en stock sin vender
        $total_stock = 0;

        foreach($purchases as $purchase){
            $total_compras += $purchase->price * $purchase->qty;
            $total_beneficio += $purchase->revenue * $purchase->qty;
            if($purchase->stock > 0){
                $total_stock += $purchase->revenue * $purchase->stock;
            }
        }
        $clients = Client::all();
        return view('home', compact('purchases', 'search', 'categories', 'filter','total_compras','total_beneficio','total_ventas','clients','total_stock','categories_sales'));
    }
    public function getSalesGraph($value){
        $data = [];
        if($value == 'week'){
            //en un array lista los 7 dias de la semana en español
            $days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
            //recorre los 7 dias de la semana
            for($i = 0; $i < 7; $i++){
                //primero verifica el dia actual
                $data[] = [
                    'labelGraph' => $days[date('w', strtotime('-'.$i.' days'))],
                    'total' => Sale::whereDate('created_at', date('Y-m-d', strtotime('-'.$i.' days')))->sum('total')
                ];
            }

        }else if($value == 'month'){
            //en un array lista los 12 meses del año en español
            $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            //recorre los 12 meses del año
            for($i = 0; $i < 12; $i++){
                $data[] = [
                    'labelGraph' => $months[date('n', strtotime('-'.$i.' month')) - 1] = $months[date('n', strtotime('-'.$i.' month')) - 1  ],
                    'total' => Sale::whereMonth('created_at', date('n', strtotime('-'.$i.' month')))->sum('total')
                ];
                // asigna los valores de todas las ventas al mes que pertenece

            }
        }else{
            //recorre los 5 ultimos años
            for($i = 0; $i < 5; $i++){
                //primero verifica el año actual
                $data[] = [
                    'labelGraph' => date('Y', strtotime('-'.$i.' years')),
                    'total' => Sale::whereYear('created_at', date('Y', strtotime('-'.$i.' years')))->sum('total')
                ];
            }
        }
        return response()->json($data);
    }
}
