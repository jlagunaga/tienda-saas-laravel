<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    //listado
    public function index(Store $store){
     $products = $store->products;
     return view('products.index', compact('store','products'));   
    }
    // crear
    public function create(Store $store){
        // traemos las categorias de la tienda
        $categories = $store->categories;
        return view('products.create', compact('store','categories'));
    }
    // guardar
    public function store(Request $request,Store $store){
        // validar datos
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'description' => 'string|nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',// maximo 2MB
        ]);
        // generar slug 
        $validate['slug'] = Str::slug($validate['name']);
        // gestionar la carga de imagen
        if($request->hasFile('image')){
            // Guarda la imagen en la carpeta 'public/products' y nos da la ruta
            $path = $request->file('image')->store('products','public');
            $validate['image_path'] = $path;
        }
        // crear el producto vinculado a la tienda
        $store->products()->create($validate);

        return redirect()->route('stores.products.index',$store)->with('status','Producto creado exitosamente.');
    }

    public function destroy(Store $store, Product $product){
        // borrar la imagen del servidor
        if ($product->image_path){
            Storage::disk('public')->delete($product->image_path);
        }
        
        // borrar el registro de la BD
        $product->delete();
        return redirect()->route('stores.products.index',$store)->with('status','Producto eliminado exitosamente.');
    }

    public function edit(Store $store, Product $product){
        $categories = $store->categories;
        return view('products.edit', compact('store','product','categories'));
    }

    public function update(Store $store, Product $product, Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'description' => 'string|nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',// maximo 2MB
        ]);
        // generar slug 
        $validated['slug'] = Str::slug($validated['name']);
        if ($request->hasFile('image')){
            // borrar imagen de storage
            if ($product->image_path){
                Storage::disk('public')->delete($product->image_path);
            }
            // Guarda la imagen en la carpeta 'public/products' y nos da la ruta
            $path = $request->file('image')->store('products','public');
            $validated['image_path'] = $path;
        }
        $product->update($validated);
        return redirect()->route('stores.products.index',$store)->with('status','Producto actualizado exitosamente.');
    }

}
