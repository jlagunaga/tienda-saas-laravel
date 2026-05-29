<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderConfirmationMail;
use App\Mail\NewOrderSellerMail;

class CheckoutController extends Controller
{
    //
    public function index(Store $store){
        // 🔒 SEGURIDAD: Forzar login del cliente
        if (!Auth::guard('customer')->check()) {
            return redirect()->guest(route('public.store.login', $store))
                             ->with('error', 'Debes iniciar sesión para completar tu compra.');
        }

        $cartkey = "Cart_{$store->id}";
        $cart = session()->get($cartkey, []);
        
        $total = 0;
        $products = collect(); // Inicializamos siempre para evitar el error que notaste
        
        if(!empty($cart)){
            $ids = array_keys($cart);
            // Usamos $store->products() para asegurar que solo vemos productos de esta tienda
            $products = $store->products()->whereIn('id', $ids)->get();
            // revision de stok antes de continuar
            foreach ($products as $product) {
                $cantidadEnCarrito = $cart[$product->id]['quantity'];
                
                if ($product->stock < $cantidadEnCarrito) {
                    return redirect()->route('public.cart.show', $store)
                                    ->withErrors(['checkout' => 'Lo sentimos, el producto "' . $product->name . '" no tiene suficiente stock. Disponibles: ' . $product->stock.' .Elimina el producto del carrito o actualiza la cantidad']);
                }
            }
            $total = 0;
            foreach ($products as $product) {
                $product->quantity = $cart[$product->id]['quantity'];
                
                // --- NUEVA LÓGICA DE DESCUENTO ---
                $precioFinal = $product->price;
                if($product->discount_percentage > 0){
                    $precioFinal = $product->price * (1 - $product->discount_percentage / 100);
                }
                $total += $precioFinal * $product->quantity;
                // ---------------------------------
            }

        }

        return view('public.checkout.show', compact('store', 'products', 'total'));
    }

    public function process(Request $request, Store $store){
        // 🔒 SEGURIDAD: Forzar login del cliente
        if (!Auth::guard('customer')->check()) {
            return redirect()->guest(route('public.store.login', $store))
                             ->with('error', 'Debes iniciar sesión para completar tu compra.');
        }
        // validaciones
        $validar = $request->validate([
                            'name'=>'required|string|max:255',
                            'email'=>'required|email|max:255',
                            'phone'=>'nullable|string|max:255',
                            'address'=>'nullable|string|max:255',
                            'references'=>'nullable|string|max:255',
                        ]);
        // array de session con datos del carrito
        $cartkey = "Cart_{$store->id}";
        $cart = session()->get($cartkey, []);

        if(empty($cart)){
            return redirect()->route('public.cart.show', $store)->with('error', 'El carrito está vacío');
        }

        $products = collect();
        $total = 0;

        $ids = array_keys($cart);
        // Usamos $store->products() para asegurar que solo vemos productos de esta tienda
        $products = $store->products()->whereIn('id', $ids)->get();

        // 🔒 SEGURIDAD CHECKOUT: Validar inventario en el último segundo
        foreach ($products as $product) {
            $cantidadEnCarrito = $cart[$product->id]['quantity'];
            
            if ($product->stock < $cantidadEnCarrito) {
                return redirect()->route('public.cart.show', $store)
                                 ->withErrors(['checkout' => 'Lo sentimos, el producto "' . $product->name . '" no tiene suficiente stock. Disponibles: ' . $product->stock.' .Elimina el producto del carrito o actualiza la cantidad']);
            }
        }
        

            foreach ($products as $product) {
                $product->quantity = $cart[$product->id]['quantity'];
                
                // --- NUEVA LÓGICA DE DESCUENTO ---
                $precioFinal = $product->price;
                if($product->discount_percentage > 0){
                    $precioFinal = $product->price * (1 - $product->discount_percentage / 100);
                }
                $total += $precioFinal * $product->quantity;
                // ---------------------------------
            }
        //preferencia de notificacion de cliente
        
        $order = $store->orders()->create([
            'customer_id' => Auth::guard('customer')->id(),
            'customer_name' => $validar['name'],
            'customer_email' => $validar['email'],
            'total' => $total,
            'status'=> 'pending_payment',
            'notify_email' => Auth::guard('customer')->user()->notify_email, // toma directamente de su cuenta registrada
        ]);

        //  Guardar/Actualizar los datos en el perfil del cliente
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            // seleccionar solo los datos enviados por el formulario q se necesitan.
            $data = $request->only('phone','address','references');
            //  Filtrar campos que no vengan vacíos.
            $dataFiltered = array_filter($data);
            // actualizacion
            $customer->update($dataFiltered);
        }


        //  guardar el detalle de orden (items)
        foreach($products as $product){
            $precioFinal = $product->price;
            if($product->discount_percentage > 0){
                $precioFinal = $product->price * (1 - $product->discount_percentage / 100);
            }
            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $product->quantity,
                'price' => $precioFinal //  precio final con descuento
            ]);
        }
        // notificar la orden al cliente q acepto notificaciones
        if($order->notify_email){
            try {
                // enviar notificacion al cliente
                Mail::to($order->customer_email)->send(new OrderConfirmationMail($order->load('items'), $store));
            } catch (\Exception $e) {
                \Log::error('Error al enviar correo de confirmación: ' . $e->getMessage());
            }
        }
        // notificar la orden al dueño de la tienda
        if($store->notify_new_order && $store->contact_email){
            try {
                // enviar notificacion al dueño de la tienda
                Mail::to($store->contact_email)->send(new NewOrderSellerMail($order, $store));
            } catch (\Exception $e) {
                \Log::error('Error al enviar correo de notificación: ' . $e->getMessage());
            }
        }   
                     


        // limpiar carrito
        session()->forget($cartkey);
        // volver a la pagina de la tienda
        // redirigir a la pagina de resumen de compra
        return redirect()->route('public.checkout.success', ['store' => $store, 'order' => $order]);
    }

    public function success(Store $store, Order $order){
        // validacion de tienda y orden
        if($store->id !== $order->store_id){
            abort(404);
        }
        return view('public.checkout.success', compact('store', 'order'));
    }
}
