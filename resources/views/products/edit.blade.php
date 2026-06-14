<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Producto para') }} {{ $store->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <!-- IMPORTANTE: enctype="multipart/form-data" para permitir subir archivos -->
                    <form method="POST" action="{{ route('stores.products.update', [$store, $product]) }}" enctype="multipart/form-data" class="max-w-xl mx-auto space-y-6">
                        @csrf
                        @method('PATCH')
                        <!-- Nombre del Producto -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre del Producto')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus placeholder="Ej: Camiseta de Algodón" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Categoría -->
                        <div>
                            <x-input-label for="category_id" :value="__('Categoría')" />
                            <select id="category_id" name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Precio y Stock -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="price" :value="__('Precio ($)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price', $product->price)" required placeholder="0.00" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="stock" :value="__('Stock')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', $product->stock)" required placeholder="0" />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>
                        </div>
                        <!-- Input del Descuento (%) -->
                        <div class="mb-4">
                            <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Descuento (%) - Opcional</label>
                            <div class="relative mt-1 border border-gray-300 rounded-md shadow-sm">
                                <input type="number" name="discount_percentage" id="discount_percentage" min="0" max="100" class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2" placeholder="Ej: 15" value="{{ old('discount_percentage', $product->discount_percentage ?? 0) }}">
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-gray-500 sm:text-sm font-bold">%</span>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('discount_percentage')" class="mt-2" />
                        </div>

                        <!-- Descripción -->
                        <div>
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" name="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{old('description', $product->description)}}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />  
                        </div>

                        <!-- Imagen -->
                        <div>
                            <x-input-label for="image" :value="__('Imagen del Producto')" />
                            @if($product->image_path)
                                <div class="mb-2">
                                    <p class="text-xs text-gray-500 mb-1">Imagen actual:</p>
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded border">
                                </div>
                            @endif
                            <input id="image" type="file" name="image" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-800 file:text-white hover:file:bg-gray-700" accept="image/*" />
                            <p class="text-xs text-gray-500 mt-1 italic">Sube una nueva foto solo si deseas cambiar la actual.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('stores.products.index', $store) }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            
                            <x-primary-button class="ml-4">
                                {{ __('Actualizar Producto') }}
                            </x-primary-button>
                        </div>
                    </form>
                    <!-- SECCIÓN DE MODERACIÓN DE RESEÑAS -->
                    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-black text-gray-900">Moderación de Reseñas</h3>
                                    <p class="text-sm text-gray-500">Oculta comentarios inapropiados del catálogo público.</p>
                                </div>
                                <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-widest">
                                    {{ $reviews->total() }} Reseñas Totales
                                </span>
                            </div>

                            @if($reviews->isEmpty())
                                <div class="p-8 text-center text-gray-500 font-medium">
                                    Este producto aún no tiene calificaciones.
                                </div>
                            @else
                                <div class="divide-y divide-gray-100">
                                    @foreach($reviews as $review)
                                        <div class="p-6 flex flex-col sm:flex-row justify-between items-start gap-4 transition hover:bg-gray-50/50">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <span class="font-bold text-gray-900">{{ $review->customer->name }}</span>
                                                    <span class="text-xs text-gray-400">•</span>
                                                    <span class="text-xs font-medium text-gray-400">{{ $review->created_at->format('d M Y') }}</span>
                                                    @if(!$review->is_visible)
                                                        <span class="bg-rose-100 text-rose-700 text-[10px] font-black uppercase px-2 py-0.5 rounded-full ml-2">
                                                            Oculto al público
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                <div class="flex text-amber-400 mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <p class="text-sm text-gray-600 {{ !$review->is_visible ? 'opacity-50 line-through' : '' }}">
                                                    {{ $review->comment ?? 'Sin comentario.' }}
                                                </p>
                                            </div>

                                            <!-- Botón Ocultar/Mostrar -->
                                            <form action="{{ route('stores.reviews.toggle', [$store, $review]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all {{ $review->is_visible ? 'bg-white border border-rose-200 text-rose-600 hover:bg-rose-50' : 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' }}">
                                                    {{ $review->is_visible ? 'Ocultar' : 'Mostrar' }}
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Paginación -->
                                <div class="p-4 border-t border-gray-100 bg-white">
                                    {{ $reviews->links() }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
