<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Review;

class SellerReviewController extends Controller
{
    //
    public function toggleVisibility(Store $store, Review $review){
        // Validar que la tienda pertenece al seller
        if ($store->user_id !== auth()->id()){
            abort(403, 'Unauthorized');
        }
        // invertir visibilidad
        $review->update([
            'is_visible' => !$review->is_visible,
        ]);
        // mensaje de respuesta
        $status = $review->is_visible ? 'visible' : 'oculta';
        return back()->with('success',"Reseña $status");
    }
    
}
