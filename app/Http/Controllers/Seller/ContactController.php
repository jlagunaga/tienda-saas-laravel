<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    //lista de mensajes
    public function index(Store $store){
        if ($store->id !== Auth::user()->id) {
            abort(403, 'unauthorized');
        }
        // lista de todos los mensajes
        $messages = $store->contactMessages()->latest()->paginate(15);

        return view('seller.contacts.index', compact('store', 'messages'));
    }
    public function show(Store $store, ContactMessage $message){
        if ($store->id !== Auth::user()->id) {
            abort(403, 'unauthorized');
        }

        // vambiamos a leido el mensaje
        $message->update(['is_read' => true]);
        
        return view('seller.contacts.show', compact('store', 'message'));
    }

}
