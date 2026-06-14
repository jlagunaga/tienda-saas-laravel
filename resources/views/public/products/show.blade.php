<x-public-layout :store="$store">
    <!-- Migas de pan (Breadcrumbs) -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex text-sm font-medium text-gray-500">
                <a href="{{ route('public.store.show', $store) }}" class="hover:text-indigo-600 transition">Inicio</a>
                <span class="mx-2">/</span>
                <a href="{{ route('public.store.category', [$store, $product->category]) }}" class="hover:text-indigo-600 transition">{{ $product->category->name }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Contenedor Principal del Producto -->
    <div class="py-12 bg-gray-50/50 min-h-[70vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                    
                    <!-- Columna Izquierda: Imagen del Producto -->
                    <div class="bg-gray-50 p-8 flex items-center justify-center relative group {{ $product->stock <= 0 ? 'opacity-85' : '' }}">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="max-h-[500px] w-auto object-contain drop-shadow-2xl group-hover:scale-105 transition duration-500 {{ $product->stock <= 0 ? 'grayscale filter' : '' }}">
                        @else
                            <div class="w-full h-96 flex flex-col items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>No hay imagen disponible</span>
                            </div>
                        @endif
                        
                        <!-- Etiqueta de Categoría Flotante -->
                        <span class="absolute top-6 left-6 px-4 py-1.5 bg-white border border-gray-200 text-xs font-bold uppercase tracking-widest text-indigo-600 rounded-full shadow-sm">
                            {{ $product->category->name }}
                        </span>
                    </div>

                    <!-- Columna Derecha: Información y Compra -->
                    <div class="p-8 md:p-12 flex flex-col justify-center">
                        <!-- Título y Precio -->
                        <h1 class="text-3xl md:text-5xl font-black text-gray-900 tracking-tight leading-tight mb-4">
                            {{ $product->name }}
                        </h1>
                        
                        @if($product->discount_percentage > 0)
                            <div class="flex items-center flex-wrap gap-4 mb-4">
                                <span class="text-4xl font-black text-indigo-600">${{ number_format($product->price * (1 - $product->discount_percentage / 100), 2) }}</span>
                                <span class="text-xl text-gray-400 line-through font-medium">${{ number_format($product->price, 2) }}</span>
                                <span class="bg-red-50 text-red-600 text-xs font-black px-3 py-1.5 rounded-lg uppercase tracking-widest border border-red-100 shadow-sm">
                                    Ahorras {{ $product->discount_percentage }}%
                                </span>
                            </div>
                        @else
                            <div class="mb-4">
                                <span class="text-4xl font-black text-gray-900">${{ number_format($product->price, 2) }}</span>
                            </div>
                        @endif

                        <!-- Descripción -->
                        <div class="prose prose-indigo text-gray-500 leading-relaxed mb-10">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-900 mb-3">Descripción del Producto</h3>
                            <p class="whitespace-pre-line">{{ $product->description ?? 'Este producto no cuenta con una descripción detallada por el momento.' }}</p>
                        </div>

                        <!-- Formulario para añadir al Carrito -->
                         @if($product->stock > 0)
                        <form action="{{ route('public.cart.add', [$store, $product]) }}" method="post" class="mt-auto">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-3 px-8 py-5 bg-gray-900 hover:bg-indigo-600 text-white text-lg font-bold rounded-2xl shadow-xl shadow-gray-200 hover:shadow-indigo-200 transition-all active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Añadir al Carrito
                            </button>
                        </form>
                        @else
                        <div class="mt-auto">
                            <div class="w-full flex items-center justify-center gap-2 px-8 py-4 bg-gray-50 border-2 border-dashed border-gray-200 text-gray-400 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                                <span class="text-sm font-bold uppercase tracking-widest">Agotado Temporalmente</span>
                            </div>
                        </div>
                        @endif
                        <!-- Garantías/Trust Badges -->
                        <div class="mt-8 pt-8 border-t border-gray-100 grid grid-cols-2 gap-4 text-center">
                            <div class="flex flex-col items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span class="text-xs font-semibold uppercase tracking-wider">Pago Seguro</span>
                            </div>
                            <div class="flex flex-col items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span class="text-xs font-semibold uppercase tracking-wider">Checkout Rápido</span>
                            </div>
                        </div>
 
                    </div>
                </div>
                <!-- SECCIÓN DE RESEÑAS -->
                <div class="mt-16 pt-10 border-t border-gray-100 max-w-4xl mx-auto">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Reseñas del Producto</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex text-amber-400">
                                    <!-- Estrellas promedio -->
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= round($product->average_rating) ? 'text-amber-400 fill-current' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-lg font-bold text-gray-900">{{ number_format($product->average_rating, 1) }} de 5</span>
                                <span class="text-sm text-gray-500">({{ $reviews->total() }} calificaciones)</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                        
                        <!-- Columna Izquierda: Formulario para calificar -->
                        <div class="md:col-span-5 lg:col-span-4">
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 sticky top-24">
                                <h3 class="font-black text-gray-900 mb-2">Evalúa este producto</h3>
                                
                                @if($hasReviewed)
                                    <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 text-sm font-bold flex items-start gap-3 mt-4">
                                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Ya has dejado tu reseña. ¡Gracias por compartir tu opinión!
                                    </div>
                                @elseif($canReview)
                                    <p class="text-sm text-gray-500 mb-6">Comparte tu experiencia con otros clientes.</p>
                                    
                                    <form action="{{ route('public.reviews.store', [$store, $product]) }}" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                                        @csrf
                                        
                                        <!-- Estrellas Interactivas con Alpine.js -->
                                        <div class="flex items-center gap-1 mb-4">
                                            <input type="hidden" name="rating" x-model="rating" required>
                                            <template x-for="i in 5" :key="i">
                                                <button type="button" 
                                                        @click="rating = i" 
                                                        @mouseenter="hoverRating = i" 
                                                        @mouseleave="hoverRating = 0"
                                                        class="focus:outline-none transition-transform hover:scale-110">
                                                    <svg class="w-8 h-8 transition-colors" 
                                                        :class="{'text-amber-400 fill-current': (hoverRating >= i || rating >= i), 'text-gray-300': (hoverRating < i && rating < i)}" 
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Comentario (Opcional)</label>
                                            <textarea name="comment" rows="4" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="¿Qué te pareció el producto?"></textarea>
                                        </div>
                                        
                                        <button type="submit" x-bind:disabled="rating === 0" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                            Publicar Reseña
                                        </button>
                                    </form>
                                @else
                                    <div class="bg-gray-100 p-4 rounded-xl text-center border-2 border-dashed border-gray-200 mt-4">
                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        <p class="text-sm font-bold text-gray-600 mb-1">Calificación Protegida</p>
                                        <p class="text-xs text-gray-500">Solo los clientes que hayan comprado este producto pueden dejar una reseña.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Columna Derecha: Lista de Comentarios -->
                        <div class="md:col-span-7 lg:col-span-8">
                            @if($reviews->isEmpty())
                                <div class="text-center py-12">
                                    <p class="text-gray-500 text-lg">Aún no hay reseñas para este producto.</p>
                                    <p class="text-gray-400 text-sm mt-1">¡Sé el primero en calificarlo tras tu compra!</p>
                                </div>
                            @else
                                <div class="space-y-6">
                                    @foreach($reviews as $review)
                                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                                            <div class="flex justify-between items-start mb-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-black uppercase">
                                                        {{ substr($review->customer->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <h4 class="font-bold text-gray-900">{{ $review->customer->name }}</h4>
                                                        <span class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                            Compra Verificada
                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="text-xs font-medium text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            
                                            <!-- Pintar las estrellas estáticas de esta reseña -->
                                            <div class="flex text-amber-400 mb-3">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                @endfor
                                            </div>

                                            @if($review->comment)
                                                <p class="text-gray-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Paginación de reseñas -->
                                <div class="mt-6">
                                    {{ $reviews->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    
</x-public-layout>
