<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    //index: listara las compras
    public function index(Store $store){
        // validamos que el usuario sea cliente
        $user = Auth::guard('customer')->user();
        
        // validamos que el cliente pertenece a esta tienda
        if($user->store_id !== $store->id){
            abort(404);
        }
        
        // Traemos los pedidos de este cliente
        $orders = $user->orders()
                                ->latest()
                                ->paginate(10);
        return view('public.customer.dashboard', compact('orders','store'));
    }

    //show: mostrara el detalle de la compra
    public function show(Store $store, Order $order){
        $user = Auth::guard('customer')->user();
        // validamos: orden con tienda y  cliente con orden
        if($order->store_id != $store->id || $order->customer_id != $user->id){
            abort(404);
        }

        // añade a la orden los order_items y los productos a cada items
        $order->load('items.product'); 

        return view('public.customer.details', compact('order','store'));
        
    }
    //updateProfile: actualizara el perfil del cliente
    public function updateProfile(Store $store, Request $request){
        $user = Auth::guard('customer')->user();
        // validamos que el usuario sea cliente
        if($user->store_id !== $store->id){
            abort(403,'unauthorized');
        }
        //validacion de campos
        $validate = $request->validate([
            'phone' => 'nullable|string|regex:/^[0-9]+$/|min:6|max:15',
            'address' => 'nullable|string|max:500',
            'references' => 'nullable|string|max:500',
        ]);
        // actualizamos el perfil del cliente
        $user->update($validate);
        return redirect()->back()->with('success','Perfil actualizado correctamente');
    }
}
