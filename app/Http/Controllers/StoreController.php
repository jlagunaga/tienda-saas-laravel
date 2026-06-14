<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Auth;

class StoreController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // regla de negocio, solo permite crear una tienda por usuario
        if (request()->user()->stores()->exists()) {
            return redirect()->route('dashboard')->with('status', 'Ya tienes una tienda creada. En este plan solo se permite 1 tienda.');
        }
        return view('stores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // regla de negocio, solo permite crear una tienda por usuario
        if (request()->user()->stores()->exists()) {
            return redirect()->route('dashboard')->with('status', 'Ya tienes una tienda creada. En este plan solo se permite 1 tienda.');
        }
        // 1. Generar el SLUG automáticamente a partir del nombre
        // Ejemplo: "Tienda de Pepe" -> "tienda-de-pepe"
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);

        // 2. Validar (Ahora incluyendo el slug generado)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:stores,slug',
        ],[
            'slug.unique' => 'El nombre de la tienda ya está registrado por otro vendedor. Por favor, elige un nombre diferente.',
        ]);

        // 3. Crear la tienda vinculada al usuario
        $request->user()->stores()->create($validated);

        return redirect()->route('dashboard')->with('status', 'Tienda creada exitosamente!');
    }
    /* Llamar formumario para Editar tienda */
    public function edit(Store $store)
    {
        // Seguridad: Verificar que la tienda pertenece al usuario logueado
        if ($store->user_id !== request()->user()->id) {
            abort(403, 'No tienes permiso para editar esta tienda.');
        }

        return view('stores.edit', compact('store'));
    }

    /* Actualizar tienda */
    public function update(Request $request, Store $store): RedirectResponse
    {
        // Seguridad: Verificar propiedad
        if ($store->user_id !== $request->user()->id) {
            abort(403, 'No tienes permiso para editar esta tienda.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'address' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096', // 4MB
            'contact_email' => 'nullable|email|max:255',
            'notify_new_order' => 'boolean',
            // datos bancarios 
            'bank_name' => 'nullable|string|max:100',
            'bank_account' => 'nullable|string|max:50',
            'bank_cci' => 'nullable|string|max:50',
            'bank_holder' => 'nullable|string|max:100',
            'payment_instructions' => 'nullable|string|max:1000',
            // datos yape
            'yape_qr_path' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'yape_phone' => 'nullable|string|max:20',
            'plin_qr_path' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'plin_phone' => 'nullable|string|max:20',
            
        ]);

        // Procesar Logo
        if ($request->hasFile('logo')) {
            // Borrar el viejo si existía
            if ($store->logo_path) {
                Storage::disk('public')->delete($store->logo_path);
            }
            // Guardar el nuevo
            $validated['logo_path'] = $request->file('logo')->store('stores/logos', 'public');
        }

        // Procesar Banner
        if ($request->hasFile('banner')) {
            // Borrar el viejo
            if ($store->banner_path) {
                Storage::disk('public')->delete($store->banner_path);
            }
            $validated['banner_path'] = $request->file('banner')->store('stores/banners', 'public');
        }

        // Procesar Yape
        if ($request->hasFile('yape_qr_path')) {
            // Borrar el viejo
            if ($store->yape_qr_path) {
                Storage::disk('public')->delete($store->yape_qr_path);
            }
            $validated['yape_qr_path'] = $request->file('yape_qr_path')->store('stores/yape', 'public');
        }

        // Procesar Plin
        if ($request->hasFile('plin_qr_path')) {
            // Borrar el viejo
            if ($store->plin_qr_path) {
                Storage::disk('public')->delete($store->plin_qr_path);
            }
            $validated['plin_qr_path'] = $request->file('plin_qr_path')->store('stores/plin', 'public');
        }

        $store->update($validated);

        return redirect()->route('dashboard')->with('status', '¡Configuración de tienda guardada exitosamente!');
    }

    public function show()
    {
        $stores = Auth::user()->stores;
        // Usamos isEmpty() porque $stores es una Colección de Laravel, no un simple array
        if($stores->isEmpty()){
            return view('dashboard', [
                'stores' => $stores, 
                'stats'  => ['revenue' => 0, 'pending' => 0, 'total' => 0]
            ]);
        }
        
        /* Seleccionamos la tienda (la primera y única) */
        $store = $stores->first();

        /* 
        **************************
            INDICADORES DE LA TIENDA 
        ************************** 
        */
        // se calcula las estadisticas optimizadas con selectRaw
        $orderStats = $store->orders()->selectRaw("
                                                    SUM(CASE WHEN status = 'completed' THEN total ELSE 0 END) as revenue,
                                                    SUM(CASE WHEN status = 'pending_payment' THEN total ELSE 0 END) as revenuePending,
                                                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_count,
                                                    COUNT(CASE WHEN status = 'pending_payment' THEN 1 END) as pending_count,
                                                    COUNT(*) as total_count
                                                ")->first();

        $stats = [
            'revenue' => $orderStats->revenue ?? 0,
            'revenuePending' => $orderStats->revenuePending ?? 0,
            'pending' => $orderStats->pending_count ?? 0,
            'completed' => $orderStats->completed_count ?? 0,
            'averageTicket' => $orderStats->completed_count > 0 ? $orderStats->revenue / $orderStats->completed_count : 0,
            'total' => $orderStats->total_count ?? 0,
        ];

        // top 5 ordenes 
        $topCustomers = $store->customers()
            ->withSum(['orders' => function($query) use ($store) {
                $query->where('store_id', $store->id); // Aseguramos que solo sume órdenes de ESTA tienda
            }], 'total') // Sumamos la columna 'total' de la tabla orders
            ->orderByDesc('orders_sum_total') // Laravel crea automáticamente este nombre de columna
            ->take(5)
            ->get();

        return view('dashboard', compact('stores','stats','topCustomers'));
    }

}
