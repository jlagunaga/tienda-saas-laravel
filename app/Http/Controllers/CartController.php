<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;

class CartController extends Controller
{
    //
    public function add(Store $store, Product $product){
        $cartkey = "Cart_{$store->id}";
        $cart = session()->get($cartkey,[]);
        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity']++;
        }else{
            $cart[$product->id] = [
                'quantity' => 1
            ];
        }
        session()->put($cartkey,$cart);
        return back()->with('success','Producto agregado al carrito');
    }

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
        
        return view('public.cart.show', compact('store', 'products', 'total'));
    }
    public function remove(Store $store, Product $product) {
        $cartkey = "Cart_{$store->id}";
        $cart = session()->get($cartkey, []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put($cartkey, $cart);
        }
        
        return back()->with('success', 'Producto eliminado del carrito');
    }

    public function decrement(Store $store, Product $product){
        $cartkey = "Cart_{$store->id}";
        $cart = session()->get($cartkey, []);
        if (isset($cart[$product->id]) ){
            if($cart[$product->id]['quantity'] > 1){
                $cart[$product->id]['quantity']--;
            }else{
                unset($cart[$product->id]);
            }
            session()->put($cartkey, $cart);
        }
        return back()->with('success', 'Producto eliminado del carrito');
    }

}
