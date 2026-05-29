@props(['store'])

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestionando: {{ $store->name }}
        </h2>
        <div class="flex space-x-8 -mb-px">
            <a href="{{ route('stores.categories.index', $store) }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('stores.categories.*') ? 'border-indigo-500 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Categorías
            </a>
            <a href="{{ route('stores.products.index', $store) }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('stores.products.*') ? 'border-indigo-500 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Productos
            </a>
            <!-- Obtenemos el conteo de órdenes pendientes para el header -->
            @php
                $headerPendingCount = $store->orders()->where('status', 'pending_payment')->count();
            @endphp
            
            <a href="{{ route('stores.orders.index', $store) }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('stores.orders.*') ? 'border-indigo-500 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Pedidos
                @if($headerPendingCount > 0)
                    <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-bold leading-none text-white bg-red-500 rounded-full">
                        {{ $headerPendingCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('stores.customers.index', $store) }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('stores.customers.*') ? 'border-indigo-500 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Clientes
            </a>
            <a href="{{ route('stores.messages.index', $store) }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('stores.message.*') ? 'border-indigo-500 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Mensajes
            </a>
        </div>
        <div class="flex space-x-4 -mb-px">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">&larr; Dashboard</a>
            <a href="{{ route('public.store.show', $store->slug) }}" target="_blank" class="text-sm text-gray-600 hover:text-gray-900 underline">Ver Tienda</a>
        </div>
    </div>
</x-slot>
