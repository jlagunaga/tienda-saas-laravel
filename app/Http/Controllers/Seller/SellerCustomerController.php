<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;



class SellerCustomerController extends Controller
{
    // lista de clientes
    public function index(Request $request, Store $store)
    {
        // asegurate de que el usuario autenticado sea el dueño de la tienda
        if ($store->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        // preparacion de query con los datos de cliente y el Q de ordenes 
        $query = $store->customers()->withCount(['orders'=> function($q)use($store){
            $q->where('store_id', $store->id);
        }]);


        // se añade filtro de busqueda en caso existe.
        if($request->has('search')){
            $query->where(function ($q)use ($request){
                $q->where('name','like',"%".$request->search."%")
                    ->orWhere('email','like',"%".$request->search."%");
            });
        }
        // paginacion
        $customers = $query->latest()->paginate(10);
        return view('seller.customers.index', compact('store','customers'));
    }

    public function show(Store $store, Customer $customer)
    {
        if ($store->user_id !== Auth::id()) {
            abort(403,'Unauthorized');
        }

        // Cargar las órdenes del cliente
        $orders = $customer->orders()
            ->with(['items.product'])
            ->where('store_id', $store->id)
            ->latest()
            ->paginate(10);

        return view('seller.customers.show', compact('store', 'customer', 'orders'));
    }
}
