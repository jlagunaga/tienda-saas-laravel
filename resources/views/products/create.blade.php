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
                    <form method="POST" action="{{ route('stores.products.store', $store) }}" enctype="multipart/form-data" class="max-w-xl mx-auto space-y-6">
                        @csrf

                        <!-- Nombre del Producto -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre del Producto')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Ej: Camiseta de Algodón" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Categoría -->
                        <div>
                            <x-input-label for="category_id" :value="__('Categoría')" />
                            <select id="category_id" name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price')" required placeholder="0.00" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="stock" :value="__('Stock')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock')" required placeholder="0" />
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
                            <textarea id="description" name="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Imagen -->
                        <div>
                            <x-input-label for="image" :value="__('Imagen del Producto')" />
                            <input id="image" type="file" name="image" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-800 file:text-white hover:file:bg-gray-700" accept="image/*" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('stores.products.index', $store) }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            
                            <x-primary-button class="ml-4">
                                {{ __('Guardar Producto') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
