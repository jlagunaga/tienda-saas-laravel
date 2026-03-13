<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Category;

class PublicStoreController extends Controller
{
    //

    public function index(Store $store){
        // cargamos los productos con categorias
        $productos = $store->products()->with('category')->latest()->get();
        // cargamos las categorias de la tienda
        $categories = $store->categories;

        return view('public.stores.show', compact('store','productos','categories'));

    }
    public function category(Store $store,Category $category){
        $productos = $store->products()->with('category')->where('category_id',$category->id)->latest()->get();

        $categories = $store->categories;
        return view('public.stores.show', compact('store','productos','categories','category'));
    }

}
