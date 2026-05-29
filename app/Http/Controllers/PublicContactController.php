<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class PublicContactController extends Controller
{
    // guardar mensaje de contacto en BD.
    public function store (Request $request, Store $store)
    {
        // validacion
        $request-> validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);
        
        // guardar mensaje
        $message = ContactMessage::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Mensaje enviado correctamente');
    }
}
