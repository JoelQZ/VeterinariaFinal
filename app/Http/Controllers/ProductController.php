<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller{
    public function index(){
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create(){
        return view('products.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
        Product::create([
            'name'  => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
        return redirect('/products')->with('success', 'Producto agregado al inventario correctamente');
    }

    public function edit(Product $product){
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product){
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();
        return redirect('/products')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect('/products')->with('success', 'Producto eliminado del inventario');
    }
}