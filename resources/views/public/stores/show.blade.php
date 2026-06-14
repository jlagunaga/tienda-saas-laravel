
<x-public-layout :store="$store">

    
    <div class="max-w-7xl mx-auto px-4 relative mb-8">
        <!-- toast de mensajes -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4" 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 3000)">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm flex justify-between items-center">
                    {{ session('success') }}
                    <button @click="show = false" class="text-green-500 hover:text-green-700 font-bold text-xl leading-none">
                        &times;
                    </button>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="max-w-7xl mx-auto px-4 mt-4" 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 3000)">
                @foreach ($errors->all() as $error)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm flex justify-between items-center">
                    {{ $error }}
                    <button @click="show = false" class="text-red-500 hover:text-red-700 font-bold text-xl leading-none">
                        &times;
                    </button>
                </div>
                @endforeach
            </div>
        @endif

        <!-- CONTENEDOR FLOTANTE: Logo + Buscador -->
        <div class="flex flex-col md:flex-row gap-4 md:gap-6 md:items-end -mt-10 sm:-mt-12">
            <!-- 1. El Logo Flotante -->
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl border-4 border-white shadow-md bg-white overflow-hidden flex-shrink-0 z-10 relative">
                <img src="{{ $store->logo_path ? asset('storage/' . $store->logo_path) : 'https://ui-avatars.com/api/?name='.urlencode($store->name).'&background=4f46e5&color=fff' }}" 
                    alt="Logo" class="w-full h-full object-cover">
            </div>

            <!-- 2. Información y Buscador alineados -->
            <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between gap-4 pb-1">
                
                <!-- Título de Bienvenida (Opcional, ya que el nombre está en el Nav) -->
                <div>
                    <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">Catálogo de Productos</h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium mt-0.5">Explora las colecciones de {{ $store->name }}</p>
                </div>

            </div>
        </div>
    </div>
    
    <div class="py-8 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Grid de categorías y productos -->
            <div class="flex flex-col sm:flex-row gap-6">            
            <!-- Sidebar: Categorías (Más compacta) -->
            <aside class="w-full sm:w-56 flex-shrink-0">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 sticky top-4">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center text-sm uppercase tracking-wider">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        Categorías
                    </h3>
                    
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('public.store.show', $store) }}" 
                               class="block px-3 py-2 rounded-xl text-sm transition {{ !isset($category) ? 'bg-indigo-600 text-white font-medium' : 'text-gray-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                                Todos los productos
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('public.store.category', [$store, $cat]) }}" 
                                   class="block px-3 py-2 rounded-xl text-sm transition {{ (isset($category) && $category->id == $cat->id) ? 'bg-indigo-600 text-white font-medium' : 'text-gray-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- Main: Listado de Productos (Más compacto) -->
            <main class="flex-1">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                        {{ isset($category) ? $category->name : 'Nuestros Productos' }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 italic">Viendo la colección de {{ $store->name }}</p>
                </div>
                <!-- FORMULARIO DE BUSQUEDA -->
                <form action="{{ route('public.store.show', $store) }}" method="GET" class="mb-6 mb-8 max-w-xl flex gap-2">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition shadow-sm" placeholder="Buscar productos en {{ $store->name }}...">
                    </div>
                    <button type="submit" class="px-6 py-3 border border-transparent text-sm font-black rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-md transition-transform active:scale-95">
                        Buscar
                    </button>
                </form>

                <!-- Grid ajustado: 4 columnas en pantallas grandes, 2 en tablets/móviles -->
                 <p class="text-sm text-gray-500 mt-1 italic mb-4">Mostrando {{$productos->count()}} de {{ $productos->total() }}</p>
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @forelse($productos as $producto)
                        
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 p-3 hover:shadow-lg transition duration-300 flex flex-col group relative {{ $producto->stock <= 0 ? 'opacity-70 bg-gray-50/50' : '' }}">
                            <!-- Contenedor de Imagen más pequeño -->
                            <div class="relative w-full h-40 overflow-hidden rounded-xl mb-3">
                                @if($producto->image_path)
                                    <a href="{{ route('public.store.product', ['store' => $store, 'product' => $producto]) }}" class="relative block w-full h-full">
                                        <!-- NUEVO: Overlay de AGOTADO sobre la imagen -->
                                        @if($producto->stock <= 0)
                                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center z-10 rounded-xl">
                                                <span class="px-2.5 py-1.5 bg-red-600 border border-red-500 text-white text-[10px] font-black uppercase tracking-widest rounded-lg shadow-md">
                                                    Agotado
                                                </span>
                                            </div>
                                        @endif
                                        <!-- Escala de grises si el stock es 0 -->
                                        <img src="{{ asset('storage/' . $producto->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 {{ $producto->stock <= 0 ? 'grayscale filter' : '' }}">
                                    </a>
                                @else
                                    <!-- Si no tiene imagen, también atenuamos con overlay -->
                                    <div class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-300 relative">
                                        @if($producto->stock <= 0)
                                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center z-10 rounded-xl">
                                                <span class="px-2.5 py-1.5 bg-red-600 border border-red-500 text-white text-[10px] font-black uppercase tracking-widest rounded-lg shadow-md">
                                                    Agotado
                                                </span>
                                            </div>
                                        @endif
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-2 left-2">
                                    <span class="text-[9px] font-bold uppercase tracking-tight text-indigo-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded-full shadow-sm">
                                        {{ $producto->category->name }}
                                    </span>
                                </div>
                                @if($producto->discount_percentage > 0)
                                    <div class="absolute top-2 right-2 bg-red-500 text-white text-[10px] uppercase font-black px-2.5 py-1 rounded-full shadow-lg z-10 border-2 border-white">
                                        -{{ $producto->discount_percentage }}%
                                    </div>
                                @endif

                            </div>
                            <a href="{{ route('public.store.product', ['store' => $store, 'product' => $producto]) }}">
                                <div class="flex-1 px-1">
                                    <h4 class="font-bold text-gray-800 text-sm line-clamp-1 group-hover:text-indigo-600 transition">{{ $producto->name }}</h4>
                                    <p class="text-gray-400 text-[11px] mt-1 line-clamp-2 leading-relaxed h-8 text-pretty">{{ $producto->description }}</p>
                                </div>
                            </a>
                            <!-- Precio y Botón más compactos -->
                            <div class="flex justify-between items-center pt-3 border-t border-gray-50">
                                <div class="flex flex-col mt-2">
                                    @if($producto->discount_percentage > 0)
                                        <span class="text-xs text-gray-400 line-through font-medium leading-none mb-1">
                                            ${{ number_format($producto->price, 2) }}
                                        </span>
                                        <span class="text-xl font-black text-indigo-600 leading-none">
                                            ${{ number_format($producto->price * (1 - $producto->discount_percentage / 100), 2) }}
                                        </span>
                                    @else
                                        <span class="text-xl font-black text-gray-900 leading-none">
                                            ${{ number_format($producto->price, 2) }}
                                        </span>
                                    @endif
                                </div>
                                @if($producto->stock > 0)
                                    <form action="{{ route('public.cart.add', [$store, $producto]) }}" method="post" class="flex items-center gap-1.5">
                                        @csrf
                                        <button type="submit" class="bg-slate-900 text-white p-2.5 rounded-xl hover:bg-indigo-600 transition shadow-md shadow-slate-200 active:scale-95 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-black rounded-md">AGOTADO</span>
                                @endif


                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-gray-200">
                            <p class="text-gray-400 text-sm">No hay productos aquí.</p>
                        </div>
                    @endforelse

                </div>
                <div class="mt-8 pt-6 border-t border-gray-100">
                    {{ $productos->links() }}
                </div>
            </main>

            </div> <!-- Cierra el flex de columnas -->
        </div> <!-- Cierra el contenedor alineado max-w-7xl -->
    </div> <!-- Cierra el fondo gris py-8 -->

    <x-public-contact-form :store="$store"/>



</x-public-layout>
