<x-public-layout :store="$store">

    <!-- En resources/views/public/checkout/show.blade.php -->
    <div class="py-12 bg-[#f8fafc]">
        <div class="max-w-4xl mx-auto px-6 mb-6">
            <a href="{{ route('public.store.show', $store) }}" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-800 transition text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Volver a la tienda
            </a>
        </div>
        <!-- Reducimos el contenedor a max-w-4xl (aprox 896px) para que no se vea tan estirado -->
        <div class="max-w-4xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
            <!-- Columna 1: Formulario -->
            <div class="bg-white p-8 md:p-10 rounded-3xl border border-slate-200 shadow-sm">
                <header class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Datos de contacto</h2>
                    <p class="text-slate-500 text-sm mt-1">Ingresa tus datos para el pedido.</p>
                </header>

                <form action="{{ route('public.checkout.process', $store) }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Grupo Nombre -->
                    <div class="space-y-2">
                        <x-input-label for="name" :value="__('Nombre Completo')" class="text-xs uppercase tracking-wider text-slate-500 font-bold" />
                        <x-text-input id="name" class="block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-2.5 px-4 text-sm shadow-sm" type="text" name="name" :value="old('name')" required placeholder="Ej: José María" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    
                    <!-- Grupo Email -->
                    <div class="space-y-2">
                        <x-input-label for="email" :value="__('Correo Electrónico')" class="text-xs uppercase tracking-wider text-slate-500 font-bold" />
                        <x-text-input id="email" class="block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-2.5 px-4 text-sm shadow-sm" type="email" name="email" :value="old('email')" required placeholder="Ej: jose@hass.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-md shadow-indigo-100 mt-4">
                        Confirmar Pedido
                    </button>
                </form>
            </div>

            <!-- Columna 2: Resumen -->
            <div class="bg-slate-50 p-8 md:p-10 rounded-3xl border border-slate-200 space-y-6">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    Resumen de compra
                </h3>
                
                <div class="space-y-3">
                    @foreach($products as $product)
                        <div class="flex justify-between items-center py-2">
                            <div class="flex items-center gap-3">
                                <span class="bg-slate-200 text-slate-700 text-[10px] font-bold px-2 py-1 rounded-md">{{ $product->quantity }}x</span>
                                <span class="text-sm font-medium text-slate-700 line-clamp-1">{{ $product->name }}</span>
                            </div>
                            <span class="text-sm font-bold text-slate-800">${{ number_format($product->price * $product->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-6 border-t border-slate-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500">Subtotal</span>
                        <span class="text-sm font-bold text-slate-700">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-lg font-bold text-slate-800">Total</span>
                        <span class="text-2xl font-black text-indigo-600">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>    
        </div>
        
    </div>


</x-public-layout>
