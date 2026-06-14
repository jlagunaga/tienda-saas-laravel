<x-app-layout>
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
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4" 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm flex justify-between items-center">
                {{ session('error') }}
                <button @click="show = false" class="text-red-500 hover:text-red-700 font-bold text-xl leading-none">
                    &times;
                </button>
            </div>
        </div>
    @endif
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('stores.orders.index', $store) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold flex items-center gap-1 mb-1 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Volver al listado
                </a>
                <h2 class="font-black text-3xl text-slate-800 leading-tight">
                    Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                </h2>
                <p class="text-slate-500 text-sm font-medium mt-1">
                    Realizado el {{ $order->created_at->format('d M, Y \a \l\a\s H:i') }}
                </p>
            </div>

            <!-- Badge de Estado Dinámico -->
            <div class="flex items-center gap-3">
                @if($order->status == 'pending_payment')
                    <span class="px-4 py-2 bg-amber-50 text-amber-700 border border-amber-200 rounded-2xl text-xs font-black uppercase tracking-widest shadow-sm">
                        ● Pendiente de Pago
                    </span>
                @elseif($order->status == 'paid')
                    <span class="px-4 py-2 bg-blue-50 text-blue-700 border border-blue-200 rounded-2xl text-xs font-black uppercase tracking-widest shadow-sm">
                        ● Pagado
                    </span>
                @elseif($order->status == 'cancelled')
                    <span class="px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-2xl text-xs font-black uppercase tracking-widest shadow-sm">
                        ● Cancelado
                    </span>
                @elseif($order->status == 'completed')
                    <span class="px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-xs font-black uppercase tracking-widest shadow-sm">
                        ● Completado
                    </span>
                @endif
            </div>

        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Columna Izquierda: Productos (Ocupa 2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200/60 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800 text-lg">Productos comprados</h3>
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">{{ $order->items->count() }} ítems</span>
                        </div>
                        
                        <div class="divide-y divide-slate-50">
                            @foreach($order->items as $item)
                                <div class="px-8 py-6 flex items-center gap-6 group hover:bg-slate-50/50 transition duration-300">
                                    <!-- Miniatura (Usamos la relación del producto) -->
                                    <div class="w-16 h-16 bg-slate-100 rounded-2xl overflow-hidden shadow-inner flex-shrink-0">
                                        @if($item->product && $item->product->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1">
                                        <h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition">{{ $item->product_name }}</h4>
                                        <p class="text-slate-400 text-sm font-medium">${{ number_format($item->price, 2) }} por unidad</p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Total ítem</p>
                                        <p class="font-black text-slate-800 text-lg">
                                            <span class="text-indigo-500 font-bold text-sm mr-1">x{{ $item->quantity }}</span>
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Footer del Resumen -->
                        <div class="bg-slate-50/50 px-8 py-6 border-t border-slate-100">
                            <div class="flex justify-between items-center max-w-xs ml-auto">
                                <span class="text-slate-500 font-bold uppercase text-xs tracking-wider">Total del Pedido</span>
                                <span class="text-3xl font-black text-indigo-600 tracking-tighter">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Datos del Cliente (Ocupa 1/3) -->
                <div class="space-y-6">
                    <div class="bg-indigo-600 rounded-[2rem] p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden group">
                        <!-- Círculo decorativo -->
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition duration-700"></div>
                        
                        <h3 class="font-bold text-indigo-100 text-xs uppercase tracking-[0.2em] mb-6">Información del Cliente</h3>
                        
                        <div class="space-y-6 relative z-10">
                            <div>
                                <p class="text-indigo-200 text-[10px] font-bold uppercase mb-1">Nombre Completo</p>
                                <p class="text-xl font-bold tracking-tight">{{ $order->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-indigo-200 text-[10px] font-bold uppercase mb-1">Correo de Contacto</p>
                                <p class="text-lg font-medium opacity-90 truncate">{{ $order->customer_email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Placeholder para Acciones Futuras -->
                    <!-- Tarjeta de Acciones del Pedido -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200/60">
                        <h3 class="font-bold text-slate-800 mb-4">Acciones</h3>
                        
                        @if($order->status == 'pending_payment')
                            <p class="text-slate-400 text-xs leading-relaxed mb-6">
                                Este pedido está pendiente de pago. Verifica haber recibido la transferencia o dinero en tus billeteras móviles antes de confirmar.
                            </p>
                            
                            <!-- Formulario de Confirmar Pago -->
                            <form action="{{ route('stores.orders.confirm-payment', $order) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label for="notes_confirm" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Notas de Pago (Opcional)</label>
                                    <input type="text" id="notes_confirm" name="notes" placeholder="Ej: Verificado vía Yape, Op #5893" class="w-full text-xs rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-3">
                                </div>
                                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-100 transition-all active:scale-95">
                                    Confirmar Pago (Descontar Stock)
                                </button>
                            </form>

                            <!-- Formulario de Cancelar Orden -->
                            <form action="{{ route('stores.orders.cancel', $order) }}" method="POST" class="space-y-4 mt-6 pt-6 border-t border-slate-100">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label for="notes_cancel" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Motivo de Cancelación (Opcional)</label>
                                    <input type="text" id="notes_cancel" name="notes" placeholder="Ej: Cliente canceló el pedido" class="w-full text-xs rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-3">
                                </div>
                                <button type="submit" onclick="return confirm('¿Estás seguro de que deseas cancelar esta orden?')" class="w-full py-3 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl font-bold text-sm transition-all active:scale-95">
                                    Cancelar Pedido
                                </button>
                            </form>

                        @elseif($order->status == 'paid')
                            <p class="text-slate-400 text-xs leading-relaxed mb-6">
                                El pago de este pedido ha sido confirmado. Una vez que hayas entregado o enviado los productos, márcalo como completado.
                            </p>
                            
                            <!-- Formulario de Completar Orden -->
                            <form action="{{ route('stores.orders.complete', $order) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label for="notes_complete" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Notas de Entrega (Opcional)</label>
                                    <input type="text" id="notes_complete" name="notes" placeholder="Ej: Enviado por Olva Courier, Guía #12345" class="w-full text-xs rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-3">
                                </div>
                                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-emerald-100 transition-all active:scale-95">
                                    Marcar como Completado
                                </button>
                            </form>

                            <!-- Formulario de Cancelar Orden (Con reintegro automático) -->
                            <form action="{{ route('stores.orders.cancel', $order) }}" method="POST" class="space-y-4 mt-6 pt-6 border-t border-slate-100">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label for="notes_cancel" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Motivo de Cancelación (Reembolso)</label>
                                    <input type="text" id="notes_cancel" name="notes" placeholder="Ej: Dinero devuelto por solicitud de cliente" class="w-full text-xs rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-3">
                                </div>
                                <button type="submit" onclick="return confirm('¿Estás seguro de cancelar esta orden? Al haber sido pagada, el stock se devolverá al inventario automáticamente.')" class="w-full py-3 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl font-bold text-sm transition-all active:scale-95">
                                    Cancelar Pedido y Devolver Stock
                                </button>
                            </form>
                        @else
                            <!-- Estado Finalizado / Cancelado -->
                            <div class="flex items-center gap-2 {{ $order->status == 'completed' ? 'text-emerald-600' : 'text-red-600' }} mb-4">
                                @if($order->status == 'completed')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-bold text-sm">Pedido Completado</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-bold text-sm">Pedido Cancelado</span>
                                @endif
                            </div>

                            @if($order->status_notes)
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs text-slate-600 mb-4 leading-relaxed">
                                    <strong class="text-slate-700 block mb-1">Observaciones / Detalles:</strong>
                                    {{ $order->status_notes }}
                                </div>
                            @endif

                            <p class="text-slate-400 text-xs leading-relaxed">
                                Este pedido ya fue procesado y no requiere más acciones.
                            </p>
                        @endif
                    </div>



                </div>

            </div>
        </div>
    </div>
</x-app-layout>
