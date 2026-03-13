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
            <main class="flex-1">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                        Carrito de compras
                    </h2>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @forelse($products as $product)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 p-3 hover:shadow-lg transition duration-300 flex flex-col group">
                            <div class="relative w-full h-40 overflow-hidden rounded-xl mb-3">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 px-1">
                                <h4 class="font-bold text-gray-800 text-sm line-clamp-1 group-hover:text-indigo-600 transition">{{ $product->name }}</h4>
                                <p class="text-gray-400 text-[11px] mt-1 line-clamp-2 leading-relaxed h-8 text-pretty">{{ $product->description }}</p>
                            </div>
                            <div class="mt-4 flex flex-col gap-4 pt-3 border-t border-gray-50">
                                <div class="flex items-center justify-between">
                                    <span class="text-base font-extrabold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                    
                                    <!-- Selector de Cantidad -->
                                    <div class="flex items-center bg-gray-100 rounded-lg p-1">
                                        <!-- Botón Menos -->
                                        <form action="{{ route('public.cart.decrement', [$store, $product]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center hover:bg-white rounded-md transition text-gray-600">-</button>
                                        </form>

                                        <span class="px-3 font-bold text-sm text-gray-800">{{ $product->quantity }}</span>

                                        <!-- Botón Más (Reutilizamos la ruta de añadir) -->
                                        <form action="{{ route('public.cart.add', [$store, $product]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center hover:bg-white rounded-md transition text-gray-600">+</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Botón Eliminar (Separado y discreto) -->
                                <form action="{{ route('public.cart.remove', [$store, $product]) }}" method="post" class="w-full text-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-400 hover:text-red-600 uppercase tracking-wider font-bold transition">
                                        Eliminar del carrito
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600 text-center">No hay productos en el carrito</p>
                    @endforelse
                </div>
                @if(!$products->isEmpty())
                    <div class="mt-10 border-t border-gray-200 pt-8 flex flex-col items-end gap-4">
                        <div class="flex items-center gap-8 mb-2">
                            <span class="text-gray-500 font-medium">Subtotal</span>
                            <span class="text-2xl font-black text-gray-900">${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <a href="{{ route('public.checkout.index', $store) }}" 
                           class="inline-flex items-center justify-center px-10 py-4 bg-indigo-600 border border-transparent rounded-2xl font-bold text-white hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 hover:scale-[1.02] active:scale-95 text-lg">
                            Finalizar Compra
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>

                        <a href="{{ route('public.store.show', $store) }}" class="text-indigo-600 font-semibold hover:text-indigo-800 transition text-sm">
                            ← Seguir comprando
                        </a>
                    </div>
                @endif

            </main>
        </div>
    </div>
</x-public-layout>