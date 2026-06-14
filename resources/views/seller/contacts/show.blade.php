<x-app-layout>
    <x-seller-store-header :store="$store" />

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Botón Volver -->
            <a href="{{ route('stores.messages.index', $store) }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-indigo-600 transition-colors mb-6 group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Volver a la bandeja
            </a>

            <!-- Contenedor del Mensaje -->
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
                <!-- Cabecera -->
                <div class="p-8 sm:p-10 border-b border-gray-100 bg-gray-50/50">
                    <h1 class="text-2xl font-black text-gray-900 mb-6">{{ $message->subject }}</h1>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <!-- Avatar de iniciales -->
                            <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-lg">
                                {{ substr($message->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $message->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <a href="mailto:{{ $message->email }}" class="text-sm font-medium text-indigo-600 hover:underline">{{ $message->email }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $message->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $message->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Cuerpo -->
                <div class="p-8 sm:p-10">
                    @if($message->phone)
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 text-sm font-bold mb-8">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            Teléfono adjunto: {{ $message->phone }}
                        </div>
                    @endif

                    <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $message->message }}
                    </div>
                </div>
                
                <!-- Acciones Rápidas -->
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex gap-3">
                    <a href="mailto:{{ $message->email }}?subject=RE: {{ urlencode($message->subject) }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                        Responder por Email
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
