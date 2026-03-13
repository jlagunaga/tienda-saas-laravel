<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestionando: {{ $store->name }}
            </h2>
            <div class="flex space-x-8 -mb-px">
                <a href="{{ route('stores.categories.index', $store) }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('stores.categories.*') ? 'border-indigo-500 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300' }}">
                    {{ __('Categorías') }}
                </a>
                <a href="{{ route('stores.products.index', $store) }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('stores.products.*') ? 'border-indigo-500 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300' }}">
                    {{ __('Productos') }}
                </a>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                &larr; Dashboard
            </a>
        </div>
    </x-slot>

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
                                                <p class="text-xs text-indigo-600 font-semibold uppercase">{{ $product->category->name }}</p>
                                            </div>
                                            <span class="font-bold text-lg text-green-600">${{ $product->price }}</span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $product->description }}</p>
                                        <div class="mt-4 flex justify-between items-center pt-4 border-t">
                                            <span class="text-xs text-gray-500">Stock: {{ $product->stock }}</span>
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
