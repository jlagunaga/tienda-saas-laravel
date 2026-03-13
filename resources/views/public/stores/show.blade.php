

<x-public-layout :store="$store">
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
    <div class="py-8 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row gap-6">
            
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

                <!-- Grid ajustado: 4 columnas en pantallas grandes, 2 en tablets/móviles -->
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @forelse($productos as $producto)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 p-3 hover:shadow-lg transition duration-300 flex flex-col group">
                            <!-- Contenedor de Imagen más pequeño -->
                            <div class="relative w-full h-40 overflow-hidden rounded-xl mb-3">
                                @if($producto->image_path)
                                    <img src="{{ asset('storage/' . $producto->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2">
                                    <span class="text-[9px] font-bold uppercase tracking-tight text-indigo-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded-full shadow-sm">
                                        {{ $producto->category->name }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex-1 px-1">
                                <h4 class="font-bold text-gray-800 text-sm line-clamp-1 group-hover:text-indigo-600 transition">{{ $producto->name }}</h4>
                                <p class="text-gray-400 text-[11px] mt-1 line-clamp-2 leading-relaxed h-8 text-pretty">{{ $producto->description }}</p>
                            </div>

                            <!-- Precio y Botón más compactos -->
                            <div class="mt-4 flex justify-between items-center pt-3 border-t border-gray-50">
                                <span class="text-base font-extrabold text-gray-900">${{ number_format($producto->price, 2) }}</span>
                                <form action="{{ route('public.cart.add', [$store, $producto]) }}" method="post">
                                    @csrf
                                    <button class="bg-gray-900 text-white p-1.5 rounded-lg hover:bg-indigo-600 transition shadow-sm group-hover:scale-110">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-gray-200">
                            <p class="text-gray-400 text-sm">No hay productos aquí.</p>
                        </div>
                    @endforelse
                </div>
            </main>

        </div>
    </div>
</x-public-layout>
