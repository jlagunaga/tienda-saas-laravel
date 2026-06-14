<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Store;
use Illuminate\Validation\Rule;


class CustomerAuthController extends Controller
{
    // mostrar formulario de registro para cliente
    public function showRegister(Store $store){
        return view('public.auth.register', compact('store'));
    }

    // procesar el registro
    public function register(Request $request, Store $store){
        // validacion
        $request->validate([
            'name' => ['required','string','max:255'],
            //Valida la unicidad en la tabla 'customers' filtrando por la tienda actual
            'email' => ['required','string','email','lowercase','max:255',
                        Rule::unique('customers','email')->where(function ($query) use ($store) {
                            return $query->where('store_id', $store->id);  
                        })],
            'password' => ['required','string','min:8','confirmed',Password::defaults()],
            'phone' => ['nullable','string','max:255'],
            'address' => ['nullable','string','max:255'],
            'references' => ['nullable','string','max:255']
        ]);

        // creado el usuario cliente
        $user = Customer::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'references' => $request->references
        ]);

        // loguear al usuario
        Auth::guard('customer')->login($user);
        // redireccionar
        return redirect()->route('public.store.show',$store)->with('status','Cuenta creada exitosamente.');

    }

    // mostrar formulario loguin
    public function showLogin(Store $store){
        return view('public.auth.login', compact('store'));
    }

    // procesar el loguin
    public function login(Request $request, Store $store){
        // validacion
        $credentials = $request->validate([
            'email' => ['required','string','email'],
            'password' => ['required','string']
        ]);


        // intentar loguear validando datos [email, password,store_id] | $request->remember=> true activa cookie de sesion
        if(Auth::guard('customer')->attempt([
                                                'email' => $request->email, 
                                                'password' => $request->password, 
                                                'store_id' => $store->id // asegura que el usuario pertenece a esta tienda
                                            ], $request->remember)){
                                                $request->session()->regenerate();// regenera el id de session
                                                return redirect()->intended(route('public.store.show',$store));
                                            }
        // error [onlyInput: retorna con valor en input email; ]
        return back()->withErrors(['email' => 
                                    'Las credenciales proporcionadas no coinciden con nuestros registros en esta tienda.']
                                    )->onlyInput('email');
    }

    // logout
    public function logout(Request $request, Store $store){
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('public.store.show', $store);
    }

    
}
