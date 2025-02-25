<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $products = Product::where('name', 'like', '%'.$search.'%')->paginate(10);
        return view('reports.index', compact('products', 'search'));
    }
}
