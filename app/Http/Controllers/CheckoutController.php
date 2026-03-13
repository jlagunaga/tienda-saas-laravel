<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;

class CheckoutController extends Controller
{
    //
    public function index(Store $store){
        $cartkey = "Cart_{$store->id}";
        $cart = session()->get($cartkey, []);
        
        $total = 0;
        $products = collect(); // Inicializamos siempre para evitar el error que notaste
        
        if(!empty($cart)){
            $ids = array_keys($cart);
            // Usamos $store->products() para asegurar que solo vemos productos de esta tienda
            $products = $store->products()->whereIn('id', $ids)->get();
            
            foreach($products as $product){
                $product->quantity = $cart[$product->id]['quantity'];
                $total += $product->price * $product->quantity;
            }
        }

        return view('public.checkout.show', compact('store', 'products', 'total'));
    }

    public function process(Request $request, Store $store){
        // validaciones
        $validar = $request->validate([
                            'name'=>'required|string|max:255',
                            'email'=>'required|email|max:255'
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
        
        foreach($products as $product){
            $product->quantity = $cart[$product->id]['quantity'];
            $total += $product->price * $product->quantity;
        }
        
        $order = $store->orders()->create([
            'customer_name' => $validar['name'],
            'customer_email' => $validar['email'],
            'total' => $total
        ]);
        //  guardar el detalle de orden (items)
        foreach($products as $product){
            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $product->quantity,
                'price' => $product->price
            ]);
        }
        // limpiar carrito
        session()->forget($cartkey);
        // volver a la pagina de la tienda
        return redirect()->route('public.store.show', $store)->with('success', 'El pedido se ha realizado correctamente');
    }
}
