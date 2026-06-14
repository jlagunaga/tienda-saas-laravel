<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Store;
use App\Mail\OrderCompletedMail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Product;


class SellerOrderController extends Controller
{
    //


    public function index(Store $store){
        // validamos si la tienda pertenece al usuario logueado
        $user = auth()->user();
        $store = $user->stores()->find($store->id);

        // Si no hubo coincidencia se muestra error 404
        if(!$store){
            abort(404);
        }

        // Traemos los pedidos de esa tienda con sus items
        $orders = $store->orders()
                            ->orderByRaw("CASE WHEN status = 'pending_payment' THEN 0 
                                                WHEN status = 'paid' THEN 1 
                                                WHEN status = 'completed' THEN 2 
                                                ELSE 3 END ASC")
                            ->orderBy('created_at','asc')
                            ->paginate(10);
        return view('seller.orders.show', compact('orders','store'));
    }

    public function details(Order $order){
        // verificar que la orden pertenezca a la tienda del vendedor
        if ($order->store_id != auth()->user()->stores()->first()->id){
            return back()->with('error','No tienes permiso para ver esta orden');
        }
        $orderItems = $order->items()->with('product')->get();
        $store = auth()->user()->stores()->first();
        return view('seller.orders.details', compact('order','orderItems','store'));
    }
    
    public function complete(Order $order, Request $request){
        // verificar que la orden pertenezca a la tienda del vendedor
        if ($order->store_id != auth()->user()->stores()->first()->id){
            return back()->with('error','No tienes permiso para ver esta orden');
        }
        if ($order->status === 'paid'){   
            $notes = $request->input('notes','');
            // actualiza estado orden
            $order->update([
                'status' =>'completed',
                'status_notes' => $notes
            ]);
            // reducir stock
            foreach($order->items as $item){
                $product = Product::find($item->product_id);
                if($product){
                    // calcular nuevo stock
                    $nuevo_stock = $product->stock - $item->quantity;
                    $nuevo_stock = $nuevo_stock>=0 ? $nuevo_stock:0;
                    $product->stock = $nuevo_stock;
                    $product->save();
                }
            }
            // Enviar notificacion al cliente
            if ($order->notify_email && $order->customer_email){
                try{
                    Mail::to($order->customer_email)->send(
                        new OrderCompletedMail(
                            $order,
                            $order->store
                        )
                    );
                }catch(Exception $e){
                    // Opcional: registrar error o notificar al administrador
                    Log::error('Error al enviar correo de confirmación de pedido: ' . $e->getMessage());
                }
            }

        }else{
            return back()->with('error','Para completar la orden, primero debe confirmarse el pago.');
        }
        return back()->with('success','Orden completada exitosamente');
    }

    public function cancel(Order $order,Request $request){
        // verificar que la orden pertenezca a la tienda del vendedor
        if ($order->store_id != auth()->user()->stores()->first()->id){
            return back()->with('error','No tienes permiso para ver esta orden');
        }

        if ($order->status === 'pending_payment' || $order->status === 'paid'){
            $notes = $request->input('notes','');
            $originalStatus = $order->status;
            // actualiza estado orden
            $order->update([
                'status' =>'cancelled', 
                'status_notes' => $notes
            ]);
            // retornar stock solo si la orden fue pagada
            if ($originalStatus === 'paid'){
                foreach($order->items as $item){
                    $product = Product::find($item->product_id);
                    if($product){
                        $product->stock += $item->quantity;
                        $product->save();
                    }
                }
            }
            return back()->with('success', 'Orden cancelada con éxito.' . ($originalStatus === 'paid' ? ' El stock ha sido reintegrado.' : ''));
        }
        return back()->with('error','Esta orden ya está finalizada y no se puede cancelar.');
    }

    public function confirmPayment(Order $order,Request $request){
        // verificar que la orden pertenezca a la tienda del vendedor
        if ($order->store_id != auth()->user()->stores()->first()->id){
            return back()->with('error','No tienes permiso para ver esta orden');
        }
        if ($order->status === 'pending_payment'){
            $notes = $request->input('notes','');
            // actualiza estado orden
            $order->update([
                'status' =>'paid',
                'status_notes' => $notes
            ]);
            // reducir stock
            foreach($order->items as $item){
                $product = Product::find($item->product_id);
                if($product){
                    // calcular nuevo stock
                    $nuevo_stock = $product->stock - $item->quantity;
                    $nuevo_stock = $nuevo_stock>=0 ? $nuevo_stock:0;
                    $product->stock = $nuevo_stock;
                    $product->save();
                }
            }
            return back()->with('success','Pago confirmado y stock descontado exitosamente.');
        }
        return back()->with('error','Esta orden no se puede marcar como pagada.');
    }
}
