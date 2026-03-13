<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class SellerOrderController extends Controller
{
    //


    public function index(){
        // Accedemos a la tienda del usuario logueado
        $user = auth()->user();
        $store = $user->stores()->first();

        // Si no tiene tienda, lo redirigimos (solo por seguridad)
        if(!$store){
            return redirect()->route('stores.create')->with('info', 'Debes crear una tienda primero');
        }

        // Traemos los pedidos de esa tienda con sus items
        $orders = $store->orders()->latest()->get();
        return view('seller.orders.show', compact('orders'));
    }

    public function details(Order $order){
        // verificar que la orden pertenezca a la tienda del vendedor
        if ($order->store_id != auth()->user()->stores()->first()->id){
            return back()->with('error','No tienes permiso para ver esta orden');
        }
        $orderItems = $order->items()->with('product')->get();

        return view('seller.orders.details', compact('order','orderItems'));
    }
    
    public function complete(Order $order){
        // verificar que la orden pertenezca a la tienda del vendedor
        if ($order->store_id != auth()->user()->stores()->first()->id){
            return back()->with('error','No tienes permiso para ver esta orden');
        }
        $order->status='completed';
        $order->save();
        return back()->with('success','Orden completada exitosamente');
    }


}
