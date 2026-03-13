<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Categoría para') }} {{ $store->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Fíjate cómo pasamos la tienda en la ruta del form -->
                    <form method="POST" action="{{ route('stores.categories.store', $store) }}" class="max-w-md mx-auto">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre de la Categoría')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Ej: Electrónica, Ropa, etc." />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('stores.categories.index', $store) }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            
                            <x-primary-button class="ml-4">
                                {{ __('Crear Categoría') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
