<x-app-layout>
    
 <x-seller-store-header :store="$store" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Gestión de Inventario</h3>
                        <a href="{{ route('stores.products.create', $store) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            + Nuevo Producto
                        </a>
                    </div>

                    @if($products->isEmpty())
                        <div class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                            <p class="text-gray-500">Aún no tienes productos en esta tienda.</p>
                        </div>
                    @else
                    <form action="{{ route('stores.products.index', $store) }}" method="GET" class="mb-8 max-w-xl flex gap-2">
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

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-gray-400italic">Sin imagen</span>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-bold text-lg text-gray-800">{{ $product->name }}</h4>
                                                <p class="text-xs text-indigo-600 font-semibold uppercase">{{ $product->category?->name ?? 'Sin categoría' }}</p>
                                            </div>
                                            @if($product->discount_percentage > 0)
                                                <div class="flex flex-col">
                                                    <!-- Precio Original Tachado -->
                                                    <span class="text-xs text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                                                    <!-- Nuevo Precio Calculado -->
                                                    <span class="text-sm font-bold text-gray-900">
                                                        ${{ number_format($product->price * (1 - $product->discount_percentage / 100), 2) }}
                                                    </span>
                                                    <!-- Etiqueta Roja -->
                                                    <span class="text-[10px] font-bold text-red-600 bg-red-100 px-1.5 py-0.5 rounded w-max mt-1 border border-red-200">
                                                        -{{ $product->discount_percentage }}% OFF
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</span>
                                            @endif

                                        </div>
                                        <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $product->description }}</p>
                                        <div class="mt-4 flex justify-between items-center pt-4 border-t">
                                            
                                            @if($product->stock == 0)
                                                <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-black rounded-md">AGOTADO</span>
                                            @elseif($product->stock <= 5)
                                                <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs font-black rounded-md mb-2">Poco Stock: {{ $product->stock }}</span>
                                            @else
                                                <span class="text-xs text-gray-500">Stock: {{ $product->stock }}</span>
                                            @endif

                                            <div class="flex space-x-2">
                                                <a href="{{route('stores.products.edit', [$store, $product])}}" class="inline-flex items-center px-2.5 py-1.5 bg-white border border-gray-300 rounded text-xs font-semibold text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                                    Editar
                                                </a>
                                                <form action="{{ route('stores.products.destroy', [$store, $product]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-red-50 border border-transparent rounded text-xs font-semibold text-red-600 uppercase tracking-widest hover:bg-red-100 active:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Borrar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
