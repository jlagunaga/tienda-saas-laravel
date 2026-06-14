<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;

class PublicReviewController extends Controller
{
    //Guardar reseña
    public function store (Request $request, Store $store, Product $product){
        $customer = auth('customer')->user();
        if (!$customer) {
            return back()->with('error', 'Debes iniciar sesión para dejar una reseña');
        }
        // Doble validacion de seguridad revisa si el cliente ha comprado el producto
        $hasPurchased = $customer->orders()
                                    ->where('store_id',$store->id)
                                    ->whereHas('items', function($query) use ($product){
                                        $query->where('product_id',$product->id);
                                    })->exists();
        if(!$hasPurchased){
            return back()->with('error', 'Debes comprar el producto para dejar una reseña');
        }

        // Validacion de datos 
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        // Guardar reseña
        $product->reviews()->create([
            'customer_id' => $customer->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_visible'=> true // visible por defecto
        ]);
        return back()->with('success','Reseña guardada exitosamente');
    }
}
