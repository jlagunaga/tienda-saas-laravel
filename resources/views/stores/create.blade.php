<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Tienda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('stores.store') }}" class="max-w-md mx-auto">
                        @csrf

                         <!-- Name -->
                         <div>
                             <x-input-label for="name" :value="__('Nombre de la Tienda')" />
                             <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ej: Mi Tienda Increíble" />
                             <x-input-error :messages="$errors->get('name')" class="mt-2" />
                             <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                             <p class="text-sm text-gray-500 mt-2">La URL de tu tienda se generará automáticamente.</p>
                         </div>


                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            
                            <x-primary-button class="ml-4">
                                {{ __('Crear Tienda') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
