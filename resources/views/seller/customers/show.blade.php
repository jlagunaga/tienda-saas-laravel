<x-app-layout>
    <x-seller-store-header :store="$store" />

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Botón Volver -->
            <div class="mb-6">
                <a href="{{ route('stores.customers.index', $store) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Volver a la Lista de Clientes
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Columna Izquierda: Tarjeta de Contacto (Perfil) -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-8">
                        <div class="flex flex-col items-center text-center pb-6 border-b border-gray-100">
                            <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-3xl font-black mb-4 uppercase shadow-inner">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                            <h2 class="text-xl font-black text-gray-900">{{ $customer->name }}</h2>
                            <p class="text-sm text-gray-500 font-medium mt-1">Cliente desde {{ $customer->created_at->format('M Y') }}</p>
                        </div>

                        <div class="pt-6 space-y-5">
                            <div>
                                <h4 class="text-[10px] uppercase tracking-widest font-black text-gray-400 mb-1">Correo Electrónico</h4>
                                <div class="flex items-center gap-2 text-gray-700 font-medium bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    <a href="mailto:{{ $customer->email }}" class="hover:text-indigo-600 transition">{{ $customer->email }}</a>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-[10px] uppercase tracking-widest font-black text-gray-400 mb-1">Teléfono / WhatsApp</h4>
                                <div class="flex items-center gap-2 text-gray-700 font-medium bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                    {{ $customer->phone ?? 'No registrado' }}
                                </div>
                            </div>

                            <div>
                                <h4 class="text-[10px] uppercase tracking-widest font-black text-gray-400 mb-1">Dirección Registrada</h4>
                                <div class="flex items-start gap-2 text-gray-700 font-medium bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <div class="flex flex-col">
                                        <span>{{ $customer->address ?? 'No registrada' }}</span>
                                        @if($customer->references)
                                            <span class="text-xs text-gray-400 mt-1 italic">Ref: {{ $customer->references }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Historial de Compras -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-6 border-b border-gray-50 pb-4">
                            <h3 class="text-lg font-black text-gray-900">Historial de Pedidos en tu Tienda</h3>
                            <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full uppercase tracking-widest">
                                Total: {{ $orders->total() }} pedidos
                            </span>
                        </div>

                        @if($orders->isEmpty())
                            <div class="text-center py-10 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <p class="text-gray-500 font-medium">Este cliente aún no ha finalizado ningún pedido.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50/50">
                                            <th class="p-4 border-b font-black text-gray-400 text-xs uppercase tracking-widest">Pedido</th>
                                            <th class="p-4 border-b font-black text-gray-400 text-xs uppercase tracking-widest text-center">Fecha</th>
                                            <th class="p-4 border-b font-black text-gray-400 text-xs uppercase tracking-widest text-center">Estado</th>
                                            <th class="p-4 border-b font-black text-gray-400 text-xs uppercase tracking-widest text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($orders as $order)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="p-4">
                                                    <a href="{{ route('stores.orders.details', $order) }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                                                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    <div class="text-[10px] text-gray-400 font-bold uppercase mt-1">
                                                        {{ $order->items->count() }} Productos
                                                    </div>
                                                </td>
                                                <td class="p-4 text-center text-sm font-medium text-gray-600">
                                                    {{ $order->created_at->format('d M Y, h:i A') }}
                                                </td>
                                                <td class="p-4 text-center">
                                                    <span class="inline-flex items-center text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                        {{ $order->status === 'completed' ? 'Completado' : 'Pendiente' }}
                                                    </span>
                                                </td>
                                                <td class="p-4 text-right font-black text-gray-900">
                                                    ${{ number_format($order->total, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Paginación -->
                            <div class="mt-6 pt-4 border-t border-gray-50">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
