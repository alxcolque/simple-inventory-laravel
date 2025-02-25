<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $products = Product::selectRaw('products.*, SUM(details.qty) as total')
                            ->join('details', 'products.id', 'details.product_id')
                            ->groupBy('products.id')
                            ->orderBy('total', 'desc')
                            ->paginate(10);


        return view('reports.index', compact('products', 'search'));
    }
}
