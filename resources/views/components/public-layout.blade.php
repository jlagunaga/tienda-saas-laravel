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
        <nav class="glass sticky top-0 z-50 border-b border-indigo-100/30 bg-white/80 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 h-18 flex items-center justify-between py-4">
                <a href="{{ route('public.store.show', $store) }}" class="text-2xl font-extrabold tracking-tight text-indigo-600 hover:text-indigo-700 transition">
                    {{ $store->name }}
                </a>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('public.cart.show', $store) }}" class="relative p-2 text-slate-600 hover:bg-slate-100 rounded-full transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @if(count(session('Cart_' . $store->id, [])) > 0)
                            <span class="absolute top-1.5 right-1.5 bg-indigo-600 text-white text-[9px] font-black w-4 h-4 flex items-center justify-center rounded-full ring-2 ring-white">
                                {{ count(session('Cart_' . $store->id, [])) }}
                            </span>
                        @endif
                    </a>

                    <div class="h-8 w-px bg-slate-200 mx-2"></div>

                    <div class="flex items-center gap-2">
                        @auth('customer')
                        
                            <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 p-1 rounded-2xl">
                                <!-- Puerta a Mis Compras -->
                                <a href="{{ route('public.customer.dashboard', $store) }}" class="flex items-center gap-2 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                    Mi Cuenta
                                </a>

                                <div class="h-3 w-px bg-slate-200 mx-1"></div>

                                <span class="text-xs font-semibold text-slate-700">Hola, <span class="text-indigo-600">{{ explode(' ', Auth::guard('customer')->user()->name)[0] }}</span></span>
                                
                                <form action="{{ route('public.store.logout', $store) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-500 transition-colors" title="Cerrar Sesión">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('public.store.login', $store) }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-slate-600 hover:text-indigo-600 transition">
                                Ingresar
                            </a>
                            <a href="{{ route('public.store.register', $store) }}" class="px-5 py-2.5 bg-slate-900 text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-indigo-600 transition shadow-lg shadow-slate-200">
                                Unirme
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </nav>
        <!-- BANNER (Más bajito para no robar pantalla) -->
        <div class="relative h-32 sm:h-48 bg-slate-100 overflow-hidden">
            @if($store->banner_path)
                <img src="{{ asset('storage/' . $store->banner_path) }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/10"></div> <!-- Un filtro muy sutil -->
            @endif
    </div>

        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Separador visual antes del footer -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent my-12"></div>

    <footer class="bg-white pb-8 pt-4">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 mb-12">
                
                <!-- Columna 1: Identidad y Descripción (Más ancha) -->
                <div class="md:col-span-5 lg:col-span-4 flex flex-col">
                    <a href="#" class="flex items-center gap-3 mb-4">
                        <img src="{{ $store->logo_path ? asset('storage/' . $store->logo_path) : 'https://ui-avatars.com/api/?name='.urlencode($store->name).'&background=4f46e5&color=fff' }}" 
                            alt="Logo" class="w-10 h-10 rounded-full object-cover border border-gray-100">
                        <span class="text-xl font-black text-gray-900 tracking-tight">{{ $store->name }}</span>
                    </a>
                    <p class="text-sm text-gray-500 leading-relaxed mb-6">
                        {{ $store->description ?? 'Ofrecemos la mejor selección de productos con la calidad que mereces. Tu satisfacción es nuestra prioridad en cada compra.' }}
                    </p>
                    
                    <!-- Redes Sociales -->
                    <div class="flex items-center gap-4">
                        @if($store->facebook_url)
                        <a href="{{ $store->facebook_url }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @endif
                        
                        @if($store->instagram_url)
                        <a href="{{ $store->instagram_url }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-pink-50 hover:text-pink-600 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Columna 2: Enlaces Rápidos -->
                <div class="md:col-span-3 lg:col-span-4">
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">Explorar</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('public.store.show', $store) }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">Catálogo de Productos</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-indigo-600 transition">Categorías</a></li>
                        @auth('customer')
                            <li><a href="{{ route('public.customer.dashboard', $store) }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">Mis Compras</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Columna 3: Contacto Directo -->
                <div class="md:col-span-4 lg:col-span-4">
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">Atención al Cliente</h3>
                    <ul class="space-y-4">
                        @if($store->whatsapp_number)
                        <li class="flex items-start gap-3 text-sm text-gray-500 hover:text-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 0C5.383 0 0 5.383 0 12.031c0 2.124.552 4.14 1.6 5.92L0 24l6.236-1.583c1.728.966 3.666 1.478 5.795 1.478 6.648 0 12.031-5.383 12.031-12.031S18.679 0 12.031 0zm4.072 17.262c-.156.44-1.547.886-2.124.966-.525.07-1.184.218-3.774-.84-3.13-1.282-5.187-4.52-5.343-4.733-.156-.21-1.272-1.684-1.272-3.21 0-1.527.8-2.28 1.085-2.58.265-.285.578-.354.767-.354.188 0 .376.002.545.01.196.01.455-.078.71.538.267.636.885 2.164.964 2.327.08.163.13.354.025.564-.103.21-.157.34-.313.525-.156.185-.33.407-.472.552-.158.163-.326.34-.145.65.18.312.8 1.32 1.714 2.138 1.18 1.056 2.176 1.382 2.49 1.532.313.15.5.127.687-.087.187-.213.805-.935 1.025-1.256.218-.32.437-.267.72-.163.284.103 1.796.848 2.103 1.002.308.155.514.23.59.36.077.13.077.747-.078 1.187z"/>
                            </svg>
                            <a href="https://wa.me/{{ $store->whatsapp_number }}?text=Hola!%20Estoy%20visitando%20la%20tienda%20online%20y%20me%20gustar%C3%ADa%20recibir%20m%C3%A1s%20informaci%C3%B3n%20sobre%20un%20producto.%20%C2%BFMe%20podr%C3%ADan%20ayudar" target="_blank" class="hover:underline">
                                {{ $store->whatsapp_number }}
                            </a>
                        </li>
                        @endif
                        
                        @if($store->email)
                        <li class="flex items-start gap-3 text-sm text-gray-500">
                            <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span>{{ $store->facebook_url }}</span>
                        </li>
                        @endif

                        @if($store->address)
                        <li class="flex items-start gap-3 text-sm text-gray-500">
                            <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span>{{ $store->address }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Copyright y Firma del SaaS -->
            <div class="border-t border-gray-100 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-400 font-medium">&copy; {{ date('Y') }} {{ $store->name }}. Todos los derechos reservados.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-[10px] text-gray-400 hover:text-indigo-600 transition font-bold uppercase tracking-wider">
                        Acceso Vendedores
                    </a>
                    <span class="text-gray-200 text-xs">|</span>
                    <p class="text-[10px] text-gray-300 font-bold uppercase tracking-widest">
                        Impulsado por <a href="#" class="text-indigo-400 hover:text-indigo-600 transition">Good Shop SaaS</a>
                    </p>
                </div>
            </div>

        </div>
    </footer>
</body>
</html>
