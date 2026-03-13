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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
