<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Categoría') }}: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('stores.categories.update', [$store, $category]) }}" class="max-w-md mx-auto">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="name" :value="__('Nombre de la Categoría')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $category->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('stores.categories.index', $store) }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Actualizar Categoría') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
