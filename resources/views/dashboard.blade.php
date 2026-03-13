<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Mis Tiendas</h3>
                    
                    @if($stores->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Aún no tienes ninguna tienda creada.</p>
                            <a href="{{ route('stores.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Crear mi primera tienda
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($stores as $store)
                                <div class="border p-4 rounded-lg hover:shadow-lg transition">
                                    <h4 class="font-bold text-lg">{{ $store->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $store->slug }}.tienda.test</p>
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Activa</span>
                                        <a href="{{route('stores.categories.index', $store)}}" class="text-indigo-600 hover:text-indigo-900 text-sm">Gestionar &rarr;</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8">
                             <a href="{{ route('stores.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                + Nueva Tienda
                            </a>
                        </div>
                    @endif
                </div>
        </div>
    </div>
</x-app-layout>
