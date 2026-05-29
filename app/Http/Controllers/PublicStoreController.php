<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;

class PublicStoreController extends Controller
{
    //

    public function index(Request $request, Store $store){
        // cargamos los productos con categorias
        $productos = $store->products()->with('category')->latest()->paginate(10);

        if($request->has('search') && $request->search != ''){
            // usamos where (function(query)... ) para evitar problemas de orden de los operadores logicos en orwhere
            $productos = $store->products()->with('category')->where(function($query) use ($request){
                $query->where('name','like','%'.$request->search.'%')
                      ->orWhere('description','like','%'.$request->search.'%');
            })->latest()->paginate(10);
        }
        // cargamos las categorias de la tienda
        $categories = $store->categories;

        return view('public.stores.show', compact('store','productos','categories'));

    }
    public function category(Store $store,Category $category){
        $productos = $store->products()->with('category')->where('category_id',$category->id)->latest()->paginate(10);

        $categories = $store->categories;
        return view('public.stores.show', compact('store','productos','categories','category'));
    }

    public function product(Store $store, Product $product){
        if($product->store_id !== $store->id){
            abort(404);
        }
        $product->load('category');

        // Cargar reseñas visibles
        $reviews = $product->reviews()->where('is_visible',true)
                        ->with('customer')
                        ->latest()
                        ->paginate(5);             

        // revisar si el cliente puede dejar reseña
        $canReview = false; // false=> no puede reseñar, true=> si puede
        $hasReviewed = false; // false => aun no reseño, true => ya reseño

        if (auth('customer')->check()){
            $customer = auth('customer')->user();
            // ya dejo reseña?
            $hasReviewed = $product->reviews()->where('customer_id',$customer->id)->exists();

            // si no tiene reseña, validamos si compro el producto en algun momento
            if(!$hasReviewed){
                $canReview = $customer->orders()
                                    ->where('store_id',$store->id)
                                    ->whereHas('items', function($query) use ($product){
                                        $query->where('product_id',$product->id);
                                    })->exists();
            }
        }
            
        return view('public.products.show', compact('store','product','reviews','canReview','hasReviewed'));
    }

}
