<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;

class CartController extends Controller
{
    //
    public function add(Store $store, Product $product,Request $request){
        // filtro 1: valida si el stock general <=0
        if($product->stock <= 0){
            return back()->withErrors(["cart"=>"Este producto esta agotado"]);
        }
        
        $cartkey = "Cart_{$store->id}";
        $cart = session()->get($cartkey,[]);
        $cantidad = $request->input('quantity', 1);
        // calculamos la cantidad total del pedido
        $catidadActual = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;
        $cantidadNueva = $catidadActual + $cantidad;

        // filtro 2: limita a no comparar mas del stock actual
        if($cantidadNueva > $product->stock){
            return back()->withErrors(["cart"=>"No puedes agregar mas de este producto, stock actual: {$product->stock}"]);
        }
        // filtro 3: limite maximo por producto 5
        if($cantidadNueva > 5){
            return back()->withErrors(["cart"=>"No puedes agregar mas de 5 unidades de este producto"]);
        }

        // ctualizamos el carrito
        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity'] += $cantidad;
        }else{
            $cart[$product->id] = [
                'quantity' => $cantidad
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
                /* cambio para aplicar descuento */
                $precioFinal = $product->price;
                if($product->discount_percentage > 0){
                    $precioFinal = $product->price * (1 - $product->discount_percentage / 100);
                }
                $total += $precioFinal * $product->quantity;
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
