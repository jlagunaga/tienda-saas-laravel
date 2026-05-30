<x-app-layout>
    <!-- Renderizar la cabecera SOLO si el vendedor tiene una tienda creada -->
    @if(!$stores->isEmpty())
        <x-seller-store-header :store="$stores->first()" />
    @endif

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                    <!-- toast de mensajes -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4" 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 3000)">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm flex justify-between items-center">
                    {{ session('success') }}
                    <button @click="show = false" class="text-green-500 hover:text-green-700 font-bold text-xl leading-none">
                        &times;
                    </button>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="max-w-7xl mx-auto px-4 mt-4" 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 3000)">
                @foreach ($errors->all() as $error)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm flex justify-between items-center">
                    {{ $error }}
                    <button @click="show = false" class="text-red-500 hover:text-red-700 font-bold text-xl leading-none">
                        &times;
                    </button>
                </div>
                @endforeach
            </div>
        @endif
        
            @if($stores->isEmpty())
                <!-- Pantalla de Bienvenida Limpia para nuevos Vendedores sin tiendas -->
                <div class="text-center py-16 bg-white border border-gray-200 rounded-[2.5rem] p-8 md:p-12 shadow-sm max-w-2xl mx-auto space-y-6 mt-10">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-indigo-50 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h2.25m-2.25 0v-4.667c0-.955-.192-1.868-.535-2.703m-5.02-3.132c.116-.277.268-.535.45-.773L12 3m0 0l-3.75 3.394C8.07 6.632 7.9 6.89 7.784 7.168M12 3v18m-7.5-6h.008v.008H4.5V15Zm0 3.75h.008v.008H4.5v-.008Zm0-7.5h.008v.008H4.5v-.008Zm15 0h.008v.008H19.5v-.008Zm0 3.75h.008v.008H19.5v-.008Z" />
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight">¡Bienvenido a skalacloud.me!</h2>
                        <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                            Estamos felices de tenerte aquí. Para comenzar a vender tus productos en línea, primero debes crear el perfil de tu tienda.
                        </p>
                    </div>
                    <a href="{{ route('stores.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-100/50">
                        Crear mi primera tienda &rarr;
                    </a>
                </div>
            @else
                <!-- Si ya tiene tiendas, mostramos toda la información de negocio y KPIs -->
                <h3 class="text-sm font-black tracking-widest uppercase text-gray-400 mb-4 ml-1">Tu Negocio</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($stores as $store)
                        @php
                            $pendingOrdersCount = $store->orders()->where('status', 'pending_payment')->count();
                        @endphp

                        <div class="border border-gray-200 p-5 rounded-xl hover:shadow-md transition bg-white">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-extrabold text-gray-800 text-xl flex items-center gap-2">
                                        {{ $store->name }}
                                        @if($pendingOrdersCount > 0)
                                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[11px] font-bold leading-none text-white bg-red-500 rounded-full animate-bounce shadow-sm">
                                                {{ $pendingOrdersCount }}
                                            </span>
                                        @endif
                                    </h4>
                                    <div class="flex items-center gap-2 mt-1.5" x-data="{ copied: false, url: '{{ route('public.store.show', $store->slug) }}' }">
                                        <p class="text-xs font-mono text-indigo-500">{{ $store->slug }}.skalacloud.me</p>
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
                                        Gestionar
                                    </a>
                                    <a href="{{ route('public.store.show', $store->slug) }}" target="_blank"
                                    class="flex items-center justify-center px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                                        Ver Tienda
                                    </a>
                                </div>
                                <a href="{{ route('stores.edit', $store) }}" target="_blank" 
                                class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors shadow-sm">
                                    Configuración de Tienda
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Reporte Financiero</h1>
                        <p class="text-sm text-gray-500 font-medium">Resumen de rendimiento de {{ $stores->first()->name }}</p>
                    </div>
                </div>

                <!-- FILA 1: TARJETAS DE KPI -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 relative overflow-hidden group">
                        <div class="relative z-10">
                            <h3 class="text-xs font-black uppercase tracking-widest text-emerald-600">Ingresos (En Caja)</h3>
                            <p class="text-3xl font-black text-gray-900 mt-4">${{ number_format($stats['revenue'], 2) }}</p>
                            <p class="text-xs font-medium text-emerald-600 mt-2">{{ $stats['completed'] }} órdenes cobradas</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-100 relative overflow-hidden group">
                        <div class="relative z-10">
                            <h3 class="text-xs font-black uppercase tracking-widest text-amber-600">Por Cobrar</h3>
                            <p class="text-3xl font-black text-gray-900 mt-4">${{ number_format($stats['revenuePending'], 2) }}</p>
                            <p class="text-xs font-medium text-amber-600 mt-2">{{ $stats['pending'] }} órdenes en tránsito</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-indigo-100 relative overflow-hidden group">
                        <div class="relative z-10">
                            <h3 class="text-xs font-black uppercase tracking-widest text-indigo-600">Volumen Total</h3>
                            <p class="text-3xl font-black text-gray-900 mt-4">{{ $stats['total'] }}</p>
                            <p class="text-xs font-medium text-indigo-600 mt-2">Pedidos registrados (Total)</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-purple-100 relative overflow-hidden group">
                        <div class="relative z-10">
                            <h3 class="text-xs font-black uppercase tracking-widest text-purple-600">Ticket Promedio</h3>
                            <p class="text-3xl font-black text-gray-900 mt-4">${{ number_format($stats['averageTicket'], 2) }}</p>
                            <p class="text-xs font-medium text-purple-600 mt-2">Gasto promedio x cliente</p>
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
                    </div>
                    
                    @if($topCustomers->isEmpty())
                        <div class="p-12 text-center">
                            <p class="text-gray-500 font-medium">Aún no hay datos suficientes de clientes.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-white border-b border-gray-100">
                                        <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest">Cliente</th>
                                        <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Órdenes</th>
                                        <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Inversión</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($topCustomers as $index => $customer)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="p-4 flex items-center gap-3">
                                                <span class="font-bold text-gray-400">#{{ $index + 1 }}</span>
                                                <div>
                                                    <p class="font-bold text-gray-900">{{ $customer->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                                                </div>
                                            </td>
                                            <td class="p-4 text-center font-medium text-gray-600">{{ $customer->orders_count ?? $customer->orders()->where('store_id', $stores->first()->id)->count() }} pedidos</td>
                                            <td class="p-4 text-right font-black text-emerald-600">${{ number_format($customer->orders_sum_total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
