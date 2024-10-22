<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    public $kardex;
    /* constructor */
    public function __construct()
    {
        $this->kardex = new Kardex();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kardexes = Kardex::all();
        return view('kardexes.index', compact('kardexes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kardex = $request->all();

        return redirect()->route('kardexes.index')->with('success', 'Kardex creado correctamente');
    }
    public static function kardeStore($kardex)
    {
        $newKardex = [];
        $newKardex['product_id'] = $kardex['product_id'];
        $newKardex['operation_date'] = $kardex['operation_date'];
        $newKardex['detail'] = $kardex['detail'];
        $newKardex['product_entry'] = $kardex['product_entry'] ?? 0;
        $newKardex['product_exit'] = $kardex['product_exit'] ?? 0;
        $newKardex['product_stock'] = $kardex['product_stock'];
        $newKardex['cost_unit'] = $kardex['cost_unit'];
        $newKardex['amount_entry'] = $kardex['amount_entry'] ?? 0;
        $newKardex['amount_exit'] = $kardex['amount_exit'] ?? 0;
        $newKardex['amount_stock'] = $kardex['amount_stock'];
        Kardex::create($newKardex);
    }

    public function getKardex($id)
    {
        $supplier = Supplier::all();
        $kardex = Product::find($id)->kardexes;
        $product = Product::find($id);
        return view('kardexes.show', compact('kardex', 'product', 'supplier'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = Supplier::all();
        $kardex = Kardex::where('product_id', $id)->get();
        return view('kardexes.show', compact('kardex', 'supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kardex $kardex)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kardex $kardex)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kardex $kardex)
    {
        //
    }
}
