<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StoreController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('stores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Generar el SLUG automáticamente a partir del nombre
        // Ejemplo: "Tienda de Pepe" -> "tienda-de-pepe"
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);

        // 2. Validar (Ahora incluyendo el slug generado)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:stores,slug',
        ]);

        // 3. Crear la tienda vinculada al usuario
        $request->user()->stores()->create($validated);

        return redirect()->route('dashboard')->with('status', 'Tienda creada exitosamente!');
    }
}
