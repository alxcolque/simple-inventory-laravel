<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $start = $request->get('start');
        $end = $request->get('end');
        if($start && $end){
            $products = Product::selectRaw('products.id, products.name, products.code, SUM(details.qty) as total')
                ->join('details', 'products.id', 'details.product_id')
                ->groupBy('products.id', 'products.name', 'products.code')
                ->whereDate('details.created_at', '>=', $start)
                ->whereDate('details.created_at', '<=', $end)
                ->paginate(10);
            return view('reports.index', compact('products', 'search'));
        }

        $time = $request->get('time-sel');
        $today = Carbon::today()->format('Y-m-d');
        if ($time == 'today') {
            //dd($time);
            $products = Product::selectRaw('products.id, products.name, products.code, SUM(details.qty) as total')
                ->join('details', 'products.id', 'details.product_id')
                ->groupBy('products.id', 'products.name', 'products.code')
                ->whereDate('details.created_at', $today)
                ->paginate(10);
            return view('reports.index', compact('products', 'search'));
        } else if ($time == 'week') {
            $week = date('Y-m-d', strtotime('-1 week'));
            $products = Product::selectRaw('products.id, products.name, products.code, SUM(details.qty) as total')
                ->join('details', 'products.id', 'details.product_id')
                ->groupBy('products.id', 'products.name', 'products.code')
                ->whereDate('details.created_at', '>=', $week)
                ->whereDate('details.created_at', '<=', $today)
                ->paginate(10);
            return view('reports.index', compact('products', 'search'));
        } else if ($time == 'month') {
            $month = date('Y-m-d', strtotime('-1 month'));
            $products = Product::selectRaw('products.id, products.name, products.code, SUM(details.qty) as total')
                ->join('details', 'products.id', 'details.product_id')
                ->groupBy('products.id', 'products.name', 'products.code')
                ->whereDate('details.created_at', '>=', $month)
                ->whereDate('details.created_at', '<=', $today)
                ->paginate(10);
            return view('reports.index', compact('products', 'search'));
        } else if ($time == 'year') {
            $year = date('Y-m-d', strtotime('-1 year'));
            $products = Product::selectRaw('products.id, products.name, products.code, SUM(details.qty) as total')
                ->join('details', 'products.id', 'details.product_id')
                ->groupBy('products.id', 'products.name', 'products.code')
                ->whereDate('details.created_at', '>=', $year)
                ->whereDate('details.created_at', '<=', $today)
                ->paginate(10);
            return view('reports.index', compact('products', 'search'));
        }

        $type = $request->get('type');
        if ($type == 'most_sold') {
            $products = Product::selectRaw('products.id, products.name, products.code, SUM(details.qty) as total')
                ->join('details', 'products.id', 'details.product_id')
                ->groupBy('products.id', 'products.name', 'products.code')
                ->orderBy('total', 'desc')
                ->paginate(10);
        } else if ($type == 'least_sold') {
            $products = Product::selectRaw('products.id, products.name, products.code, SUM(details.qty) as total')
                ->join('details', 'products.id', 'details.product_id')
                ->groupBy('products.id', 'products.name', 'products.code')
                ->orderBy('total', 'ASC')
                ->paginate(10);
        } else {
            //$products = Product::where('name', 'like', '%'.$search.'%')->paginate(10);
            $products = Product::selectRaw('products.id, products.name, products.code, SUM(details.qty) as total')
                ->where('name', 'like', '%' . $search . '%')
                ->join('details', 'products.id', 'details.product_id')
                ->groupBy('products.id', 'products.name', 'products.code')
                ->paginate(10);
            if ($products->isEmpty()) {
                return back()->with('warning', 'No se encontraron productos');
            }
        }

        return view('reports.index', compact('products', 'search'));
    }
}
