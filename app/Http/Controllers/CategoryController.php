<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\View\View;



class CategoryController extends Controller
{
    /* 
    Listado de categorías de una tienda específica
     */
    public function index(Store $store){
    // 1. Buscamos las categorías que tengan el store_id de esta tienda
        $categories = $store->categories;

    // 2. Cargamos la vista de listado
    return view('categories.index', compact('store','categories'));
    }

    public function create(Store $store){
        return view('categories.create', compact('store'));
    }

    public function store(Request $request , Store $store ){
        // 1. Generar el slug automáticamente
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);   
        // 2. validar
        $validar = $request->validate([
                                    'name'=>'required|string|max:255',
                                    'slug'=>'required|string|max:255|unique:categories,slug'
                                ]);
        // 3. Guardar                   
        $store->categories()->create($validar);

        // 4. redirigir al listado de categoria

        return redirect()->route('stores.categories.index', $store)->with('status','Categoria creada con exito');
    }
    public function destroy(Store $store, Category $category){
        // El Route Model Binding ya nos da la categoría lista
        $category->delete();

        return redirect()->route('stores.categories.index',$store)->with('status','Categoria eliminada con exito'); 
    }


    public function edit(Store $store, Category $category){
        return view('categories.edit', compact('store','category'));
    }
    
    public function update(Request $request, Store $store, Category $category){
        $validate = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        // actualizar el slug
        $validate['slug'] = Str::slug($validate['name']);
        $category->update($validate);
        return redirect()->route('stores.categories.index', $store)->with('status','Categoria actualizada con exito');
    }

}
