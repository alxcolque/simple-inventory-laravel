<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\CPU\FileManager;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private const FOLDER_PATH_LOCAL = 'images/products';
    public function index(Request $request)
    {
        $search = $request->get('search');
        if($request->get('category')){
            $products = Product::where('category_id', $request->get('category'))->paginate(10);
        }else{

            $products = Product::where('name', 'like', '%'.$search.'%')->paginate(10);
        }
        // Filtra todas las categorias de la realcion de productos y las guarda en la variable $categories
        $categories = Product::all()->pluck('category')->unique();

        return view('products.index', compact('products', 'search', 'categories'));
    }
    public function create()
    {
        $categories = Category::all();
        // genera un nuevo codigo de producto unico en la base de datos
        $code = 'PROD-'.str_pad(Product::all()->count() + 1, 4, '0', STR_PAD_LEFT);
        return view('products.create', compact('categories', 'code'));
    }
    private function generateSlug($title)
    {
        $slug = Str::slug($title);
        $count = Category::where('slug', 'LIKE', $slug . '%')->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        return $slug;
    }
    public function store(ProductRequest $request)
    {
        //dd($request->all());
        $product = new Product;
        $product->name = $request->name;
        $product->slug = $this->generateSlug($request->name);
        $product->category_id = $request->category_id;
        $product->code = $request->code;
        $product->description = $request->description;
        $fileImage  = $request->file('image');
        if ($fileImage) {
            $url = FileManager::upload($fileImage, $this::FOLDER_PATH_LOCAL);
            if ($url == 'Error33') {
                return back()->with('error', 'Error url!');
            }else {
                $product->image = $url;
            }
        }
        $product->save();
        return redirect()->route('products.index')->with('success', 'Producto creado correctamente');
    }

    public function show($id){
        $product = Product::find($id);
        return view('products.show', compact('product'));
    }
    public function edit($id)
    {
        $categories = Category::all();
        $code = 'PROD-'.str_pad(Product::all()->count() + 1, 4, '0', STR_PAD_LEFT);
        $product = Product::find($id);
        return view('products.edit', compact('product','categories','code'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        if($product->slug !== Str::slug($request->name)) {
            $product->slug = $this->generateSlug($request->name);
        }
        $product->category_id = $request->category_id;
        $product->code = $request->code;
        $product->description = $request->description;
        $fileImage  = $request->file('image');
        if ($fileImage) {
            FileManager::delete($product->image, 'key_image');
            $url = FileManager::upload($fileImage, $this::FOLDER_PATH_LOCAL);
            if ($url == 'Error33') {
                return back()->with('error', 'Error url!');
            }else {
                $product->image = $url;
            }
        }
        $product->save();
        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        FileManager::delete($product->image, 'key_image');
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente');
    }
}
