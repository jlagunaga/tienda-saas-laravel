<x-app-layout>
    <x-seller-store-header :store="$stores->first()" />

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Tu vista de Negocio (El recuadro de la tienda) -->
            @if($stores->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">Aún no tienes ninguna tienda creada.</p>
                    <a href="{{ route('stores.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Crear mi primera tienda
                    </a>
                </div>
            @else
                <h3 class="text-sm font-black tracking-widest uppercase text-gray-400 mb-4 ml-1">Tu Negocio</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($stores as $store)
                        <!-- Obtenemos el conteo de órdenes pendientes para esta tienda -->
                        @php
                            $pendingOrdersCount = $store->orders()->where('status', 'pending_payment')->count();
                        @endphp

                        <div class="border border-gray-200 p-5 rounded-xl hover:shadow-md transition bg-white">
                            <div class="flex justify-between items-start">
                                <div>
                                    <!-- Añadimos el badge rojo animado si hay órdenes pendientes -->
                                    <h4 class="font-extrabold text-gray-800 text-xl flex items-center gap-2">
                                        {{ $store->name }}
                                        @if($pendingOrdersCount > 0)
                                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[11px] font-bold leading-none text-white bg-red-500 rounded-full animate-bounce shadow-sm">
                                                {{ $pendingOrdersCount }}
                                            </span>
                                        @endif
                                    </h4>
                                    <!-- Botón interactivo de Copiado Rápido con Alpine.js -->
                                    <div class="flex items-center gap-2 mt-1.5" x-data="{ copied: false, url: '{{ route('public.store.show', $store->slug) }}' }">
                                        <p class="text-xs font-mono text-indigo-500">{{ $store->slug }}.tienda.test</p>
                                        <button type="button" @click="navigator.clipboard.writeText(url); copied = true; setTimeout(() => copied = false, 2000)" 
                                                class="text-[10px] font-bold text-slate-400 hover:text-indigo-600 transition flex items-center gap-1 focus:outline-none bg-slate-50 hover:bg-indigo-50 px-2 py-0.5 rounded-md border border-slate-100 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                            <span x-text="copied ? '¡Copiado!' : 'Copiar'"></span>
                                        </button>
                                    </div>

                                </div>
                                <span class="text-[10px] uppercase tracking-widest font-bold bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                    Activa
                                </span>
                            </div>


                        <div class="mt-6 space-y-3">
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{route('stores.categories.index', $store)}}" 
                                class="flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Gestionar
                                </a>

                                <a href="{{ route('public.store.show', $store->slug) }}" target="_blank"
                                class="flex items-center justify-center px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Ver Tienda
                                </a>
                            </div>

                            <a href="{{ route('stores.edit', $store) }}" target="_blank" 
                            class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.781.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                Configuración de Tienda
                            </a>
                        </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-black text-gray-900 tracking-tight">Reporte Financiero</h1>
                    <p class="text-sm text-gray-500 font-medium">Resumen de rendimiento de {{ $stores->first()->name }}</p>
                </div>
            </div>

            <!-- FILA 1: TARJETAS DE KPI (Consumiendo tu array $stats) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Tarjeta 1: Ingresos Reales (Completed) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-black uppercase tracking-widest text-emerald-600">Ingresos (En Caja)</h3>
                            <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-black text-gray-900">${{ number_format($stats['revenue'], 2) }}</p>
                        <p class="text-xs font-medium text-emerald-600 mt-2 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            {{ $stats['completed'] }} órdenes cobradas
                        </p>
                    </div>
                </div>

                <!-- Tarjeta 2: Dinero Pendiente -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-100 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-black uppercase tracking-widest text-amber-600">Por Cobrar</h3>
                            <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-black text-gray-900">${{ number_format($stats['revenuePending'], 2) }}</p>
                        <p class="text-xs font-medium text-amber-600 mt-2 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                            {{ $stats['pending'] }} órdenes en tránsito
                        </p>
                    </div>
                </div>

                <!-- Tarjeta 3: Órdenes Totales -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-indigo-100 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-black uppercase tracking-widest text-indigo-600">Volumen Total</h3>
                            <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-black text-gray-900">{{ $stats['total'] }}</p>
                        <p class="text-xs font-medium text-indigo-600 mt-2">
                            Pedidos registrados (Total)
                        </p>
                    </div>
                </div>

                <!-- Tarjeta 4: Ticket Promedio -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-purple-100 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-black uppercase tracking-widest text-purple-600">Ticket Promedio</h3>
                            <div class="p-2 bg-purple-100 rounded-lg text-purple-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            </div>
                        </div>
                        <!-- Cuidado aquí: estoy usando 'averageTicket' tal como lo escribiste en tu controlador -->
                        <p class="text-3xl font-black text-gray-900">${{ number_format($stats['averageTicket'], 2) }}</p>
                        <p class="text-xs font-medium text-purple-600 mt-2">
                            Gasto promedio x cliente
                        </p>
                    </div>
                </div>
            </div>

            <!-- FILA 2: TOP CLIENTES -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Mejores Clientes (Top 5)</h3>
                        <p class="text-xs text-gray-500 mt-1">Clientes que más dinero han dejado en tu tienda.</p>
                    </div>
                    <a href="{{ route('stores.customers.index', $stores->first()) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">Ver todos &rarr;</a>
                </div>
                
                @if($topCustomers->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <p class="text-gray-500 font-medium">Aún no hay datos suficientes de clientes.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white border-b border-gray-100">
                                    <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest">Cliente</th>
                                    <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Órdenes Realizadas</th>
                                    <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Inversión Total</th>
                                    <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($topCustomers as $index => $customer)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="p-4 flex items-center gap-3">
                                            <!-- Medallitas para los 3 primeros lugares -->
                                            @if($index === 0) <span class="text-xl">🥇</span>
                                            @elseif($index === 1) <span class="text-xl">🥈</span>
                                            @elseif($index === 2) <span class="text-xl">🥉</span>
                                            @else <span class="text-sm font-bold text-gray-400 w-6 text-center">#{{ $index + 1 }}</span>
                                            @endif
                                            
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $customer->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                                            </div>
                                        </td>
                                        <td class="p-4 text-center font-medium text-gray-600">
                                            {{ $customer->orders_count ?? $customer->orders()->where('store_id', $stores->first()->id)->count() }} pedidos
                                        </td>
                                        <td class="p-4 text-right font-black text-emerald-600">
                                            ${{ number_format($customer->orders_sum_total, 2) }}
                                        </td>
                                        <td class="p-4 text-center">
                                            <a href="{{ route('stores.customers.show', [$stores->first(), $customer]) }}" class="inline-flex items-center justify-center p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
