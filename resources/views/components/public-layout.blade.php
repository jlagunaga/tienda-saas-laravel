<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- En el <head> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
    </style>

    <title>{{ $store->name ?? 'Tienda' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-900 antialiased bg-[#f8fafc]">
    <div class="min-h-screen">
        <!-- Barra de navegación simple y pública -->
        <nav class="glass sticky top-0 z-50 border-b border-indigo-100/30">
            <div class="max-w-7xl mx-auto px-4 h-18 flex items-center justify-between py-4">
                <a href="{{ route('public.store.show', $store) }}" class="text-2xl font-extrabold tracking-tight text-indigo-600 hover:text-indigo-700 transition">
                    {{ $store->name }}
                </a>
                
                <div class="flex items-center gap-6">
                    <!-- Botón del Carrito con diseño más limpio -->
                    <a href="{{ route('public.cart.show', $store) }}" class="relative group p-2.5 bg-indigo-50/50 rounded-2xl hover:bg-indigo-600 transition-all duration-300 shadow-sm hover:shadow-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white shadow-sm">
                            {{ count(session('Cart_' . $store->id, [])) }}
                        </span>
                    </a>

                    <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition">
                        Vendedores
                    </a>
                </div>
            </div>
        </nav>


        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
