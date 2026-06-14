@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        
        <!-- Paginador para Celulares (Botones Anchos) -->
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 cursor-not-allowed rounded-xl">
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-indigo-600 bg-white border border-indigo-200 rounded-xl hover:bg-indigo-50 shadow-sm transition">
                    Anterior
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-bold text-indigo-600 bg-white border border-indigo-200 rounded-xl hover:bg-indigo-50 shadow-sm transition">
                    Siguiente
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 cursor-not-allowed rounded-xl">
                    Siguiente
                </span>
            @endif
        </div>

        <!-- Paginador para Computadoras (Números y Flechas) -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between px-2">
            <div>
                <p class="text-sm text-gray-500">
                    Viendo <span class="font-bold text-gray-900">{{ $paginator->firstItem() }}</span> a <span class="font-bold text-gray-900">{{ $paginator->lastItem() }}</span> de <span class="font-bold text-gray-900">{{ $paginator->total() }}</span> resultados
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-xl overflow-hidden border border-gray-200 bg-white">
                    
                    {{-- Botón de Flecha Anterior (Izquierda) --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-50 cursor-not-allowed h-full">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50 transition h-full">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        </a>
                    @endif

                    {{-- Los Números de las Páginas --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border-l border-gray-200 cursor-default">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <!-- ESTE ES EL NÚMERO DE LA PÁGINA ACTUAL -->
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-black text-white bg-indigo-600 border-l border-indigo-600 cursor-default shadow-inner">{{ $page }}</span>
                                    </span>
                                @else
                                    <!-- ESTOS SON LOS OTROS NÚMEROS -->
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-gray-500 bg-white border-l border-gray-200 hover:text-indigo-600 hover:bg-indigo-50 transition">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Botón de Flecha Siguiente (Derecha) --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-indigo-600 bg-white border-l border-gray-200 hover:bg-indigo-50 transition h-full">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    @else
                        <span aria-disabled="true">
                            <span class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-gray-300 bg-gray-50 border-l border-gray-200 cursor-not-allowed h-full">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
