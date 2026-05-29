<x-app-layout>
    <x-seller-store-header :store="$store" />

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    
            <!-- CABECERA DE SECCIÓN: Con Acciones Rápidas -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Bandeja de Mensajes</h2>
                        <!-- Contador de No Leídos -->
                        @php $unreadCount = $messages->where('is_read', false)->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-600 text-white shadow-sm">
                            {{ $unreadCount }} nuevos
                        </span>
                    @endif
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Gestiona las consultas y prospectos de {{ $store->name }}.</p>
                </div>

                <!-- Acciones Globales (Opcional) -->
                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-all shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Marcar todo como leído
                    </button>
                </div>
            </div>

            <!-- CONTENEDOR PRINCIPAL: Estilo Inbox -->
            <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        
            <!-- Barra de Filtros Interna (Sutil) -->
            <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-3 flex items-center justify-between">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Remitente / Asunto</span>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Recibido</span>
            </div>

            <!-- LISTA DE MENSAJES -->
            <div class="divide-y divide-gray-50">
                @forelse($messages as $msg)
                    <a href="{{ route('stores.message.show', [$store, $msg]) }}" 
                   class="group relative flex items-center gap-4 p-5 hover:bg-indigo-50/20 transition-all {{ !$msg->is_read ? 'bg-indigo-50/40' : 'bg-white' }}">
                    
                    <!-- Borde de estado lateral -->
                    @if(!$msg->is_read)
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500"></div>
                    @endif

                    <div class="flex-1 min-w-0 grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                        
                        <!-- Columna: Persona -->
                        <div class="sm:col-span-3 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ !$msg->is_read ? 'from-indigo-500 to-purple-600' : 'from-gray-100 to-gray-200' }} flex items-center justify-center text-white text-[10px] font-bold">
                                {{ strtoupper(substr($msg->name, 0, 2)) }}
                            </div>
                            <p class="text-sm font-bold truncate {{ !$msg->is_read ? 'text-indigo-900' : 'text-gray-700' }}">
                                {{ $msg->name }}
                            </p>
                        </div>

                        <!-- Columna: Contenido -->
                        <div class="sm:col-span-7 flex items-center gap-2 truncate">
                            <p class="text-sm truncate {{ !$msg->is_read ? 'font-bold text-gray-900' : 'font-medium text-gray-600' }}">
                                {{ $msg->subject }}
                            </p>
                            <span class="text-gray-300">-</span>
                            <p class="text-sm text-gray-400 truncate">
                                {{ Str::limit($msg->message, 80) }}
                            </p>
                        </div>

                        <!-- Columna: Fecha -->
                        <div class="sm:col-span-2 text-right">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">
                                {{ $msg->created_at->isToday() ? $msg->created_at->format('h:i A') : $msg->created_at->format('d M, Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Icono de flecha que aparece al hacer hover -->
                    <div class="hidden sm:block opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </div>
                </a>
                @empty
                <div class="p-20 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    </div>
                    <p class="text-gray-500 font-medium">No hay mensajes por aquí todavía.</p>
                </div>
                @endforelse
            </div>

            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
