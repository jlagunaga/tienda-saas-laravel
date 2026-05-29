<x-public-layout :store="$store">
    <div class="py-12 bg-[#f8fafc] min-h-screen flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto px-6">
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-indigo-100/50 p-8 md:p-12 relative overflow-hidden border border-slate-100">
                
                <!-- Círculo decorativo de fondo -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-50 rounded-full blur-2xl"></div>

                <!-- Icono de Éxito Animado -->
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-emerald-100 mb-6 relative z-10">
                    <svg class="h-10 w-10 text-emerald-600 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight mb-2">
                        ¡Gracias por tu compra!
                    </h2>
                    <p class="text-slate-500 text-sm">
                        Tu orden ha sido registrada correctamente. A continuación tienes las instrucciones para realizar tu pago manual y confirmar tu pedido.
                    </p>
                </div>

                <!-- Tarjeta del Número de Orden -->
                <div class="bg-slate-50 rounded-3xl p-6 mb-8 border border-slate-100/80 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-center sm:text-left">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Número de Orden</p>
                        <p class="text-3xl font-black text-indigo-600 font-mono tracking-tighter">
                            #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>
                    <div class="text-center sm:text-right">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Monto a Pagar</p>
                        <p class="text-3xl font-black text-slate-800 tracking-tight">
                            ${{ number_format($order->total, 2) }}
                        </p>
                    </div>
                </div>

                <!-- SECCIÓN DE MÉTODOS DE PAGO CONFIGURADOS -->
                <div class="space-y-6 mb-8">
                    <h3 class="text-sm font-black uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2">Instrucciones de Pago</h3>
                    
                    @if($store->payment_instructions)
                        <div class="bg-indigo-50/50 rounded-2xl p-5 border border-indigo-100/40 text-xs text-indigo-900 leading-relaxed font-medium">
                            <span class="font-extrabold uppercase text-[10px] text-indigo-600 block mb-1">Mensaje del vendedor:</span>
                            {!! nl2br(e($store->payment_instructions)) !!}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- 🏦 Transferencia Bancaria -->
                        @if($store->bank_name && $store->bank_account)
                            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                                <div class="flex items-center gap-2">
                                    <span class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </span>
                                    <h4 class="font-extrabold text-slate-800 text-sm">Transferencia Bancaria</h4>
                                </div>
                                <div class="space-y-3 text-xs">
                                    <div>
                                        <span class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">Banco</span>
                                        <p class="font-extrabold text-slate-800 text-sm">{{ $store->bank_name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">Titular de la Cuenta</span>
                                        <p class="font-bold text-slate-700">{{ $store->bank_holder ?? $store->name }}</p>
                                    </div>
                                    <div x-data="{ copied: false, text: '{{ $store->bank_account }}' }">
                                        <span class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">Nro de Cuenta</span>
                                        <div class="flex items-center justify-between bg-slate-50 border border-slate-100 rounded-xl px-3 py-1.5 mt-0.5">
                                            <span class="font-mono font-bold text-slate-800">{{ $store->bank_account }}</span>
                                            <button @click="navigator.clipboard.writeText(text); copied = true; setTimeout(() => copied = false, 2000)" type="button" class="text-[10px] font-black text-indigo-600 hover:text-indigo-800">
                                                <span x-text="copied ? '¡Copiado!' : 'Copiar'"></span>
                                            </button>
                                        </div>
                                    </div>
                                    @if($store->bank_cci)
                                        <div x-data="{ copied: false, text: '{{ $store->bank_cci }}' }">
                                            <span class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">CCI (Interbancario)</span>
                                            <div class="flex items-center justify-between bg-slate-50 border border-slate-100 rounded-xl px-3 py-1.5 mt-0.5">
                                                <span class="font-mono font-bold text-slate-800">{{ $store->bank_cci }}</span>
                                                <button @click="navigator.clipboard.writeText(text); copied = true; setTimeout(() => copied = false, 2000)" type="button" class="text-[10px] font-black text-indigo-600 hover:text-indigo-800">
                                                    <span x-text="copied ? '¡Copiado!' : 'Copiar'"></span>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- 📱 Billeteras Digitales (Yape / Plin) -->
                        @if(($store->yape_phone || $store->yape_qr_path) || ($store->plin_phone || $store->plin_qr_path))
                            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                                <div class="flex items-center gap-2">
                                    <span class="p-1.5 bg-purple-50 text-purple-600 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <h4 class="font-extrabold text-slate-800 text-sm">Billeteras Móviles</h4>
                                </div>
                                
                                <div class="space-y-4 text-xs">
                                    <!-- Yape -->
                                    @if($store->yape_phone || $store->yape_qr_path)
                                        <div class="border-b border-slate-100 pb-3 last:border-0 last:pb-0">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="px-2 py-0.5 bg-purple-100 text-purple-700 font-black rounded text-[9px] uppercase tracking-wider">YAPE</span>
                                                @if($store->yape_phone)
                                                    <div x-data="{ copied: false, text: '{{ $store->yape_phone }}' }" class="flex items-center gap-1.5">
                                                        <span class="font-bold text-slate-700 font-mono">{{ $store->yape_phone }}</span>
                                                        <button @click="navigator.clipboard.writeText(text); copied = true; setTimeout(() => copied = false, 2000)" type="button" class="text-[9px] font-black text-indigo-600 hover:text-indigo-800">
                                                            <span x-text="copied ? '¡Copiado!' : 'Copiar'"></span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($store->yape_qr_path)
                                                <div class="flex justify-center p-2 bg-slate-50 rounded-2xl border border-slate-100 max-w-[140px] mx-auto">
                                                    <img src="{{ asset('storage/' . $store->yape_qr_path) }}" alt="QR Yape" class="w-full h-auto rounded-lg object-contain">
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Plin -->
                                    @if($store->plin_phone || $store->plin_qr_path)
                                        <div class="pt-1 last:border-0 last:pb-0">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="px-2 py-0.5 bg-teal-100 text-teal-700 font-black rounded text-[9px] uppercase tracking-wider">PLIN</span>
                                                @if($store->plin_phone)
                                                    <div x-data="{ copied: false, text: '{{ $store->plin_phone }}' }" class="flex items-center gap-1.5">
                                                        <span class="font-bold text-slate-700 font-mono">{{ $store->plin_phone }}</span>
                                                        <button @click="navigator.clipboard.writeText(text); copied = true; setTimeout(() => copied = false, 2000)" type="button" class="text-[9px] font-black text-indigo-600 hover:text-indigo-800">
                                                            <span x-text="copied ? '¡Copiado!' : 'Copiar'"></span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($store->plin_qr_path)
                                                <div class="flex justify-center p-2 bg-slate-50 rounded-2xl border border-slate-100 max-w-[140px] mx-auto">
                                                    <img src="{{ asset('storage/' . $store->plin_qr_path) }}" alt="QR Plin" class="w-full h-auto rounded-lg object-contain">
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- BOTÓN PRINCIPAL DE WHATSAPP -->
                @if($store->whatsapp_number)
                    @php
                        $mensaje = "¡Hola! Acabo de realizar mi pedido #" . str_pad($order->id, 5, '0', STR_PAD_LEFT) . " en tu tienda por un total de $" . number_format($order->total, 2) . ". Adjunto aquí el comprobante de mi pago.";
                        $whatsapp_url = "https://wa.me/" . preg_replace('/[^0-9]/', '', $store->whatsapp_number) . "?text=" . urlencode($mensaje);
                    @endphp
                    
                    <div class="bg-emerald-50 rounded-3xl p-6 border border-emerald-100/60 mb-8 space-y-4">
                        <div class="text-center">
                            <h4 class="font-extrabold text-emerald-800 text-sm">¿Ya realizaste la transferencia o pago móvil?</h4>
                            <p class="text-emerald-600 text-xs mt-1">Haz clic abajo para enviar tu comprobante directamente al vendedor por WhatsApp y agilizar tu envío.</p>
                        </div>
                        <a href="{{ $whatsapp_url }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-extrabold text-sm tracking-wide transition duration-300 shadow-md shadow-emerald-100 active:scale-[0.98]">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 0C5.383 0 0 5.383 0 12.031c0 2.124.552 4.14 1.6 5.92L0 24l6.236-1.583c1.728.966 3.666 1.478 5.795 1.478 6.648 0 12.031-5.383 12.031-12.031S18.679 0 12.031 0zm4.072 17.262c-.156.44-1.547.886-2.124.966-.525.07-1.184.218-3.774-.84-3.13-1.282-5.187-4.52-5.343-4.733-.156-.21-1.272-1.684-1.272-3.21 0-1.527.8-2.28 1.085-2.58.265-.285.578-.354.767-.354.188 0 .376.002.545.01.196.01.455-.078.71.538.267.636.885 2.164.964 2.327.08.163.13.354.025.564-.103.21-.157.34-.313.525-.156.185-.33.407-.472.552-.158.163-.326.34-.145.65.18.312.8 1.32 1.714 2.138 1.18 1.056 2.176 1.382 2.49 1.532.313.15.5.127.687-.087.187-.213.805-.935 1.025-1.256.218-.32.437-.267.72-.163.284.103 1.796.848 2.103 1.002.308.155.514.23.59.36.077.13.077.747-.078 1.187z"/>
                            </svg>
                            Enviar Comprobante por WhatsApp
                        </a>
                    </div>
                @endif

                <a href="{{ route('public.store.show', $store) }}" class="inline-flex items-center justify-center w-full px-6 py-4 border border-slate-200 text-sm font-bold rounded-2xl text-slate-600 bg-white hover:bg-slate-50 transition duration-300">
                    ← Volver a la tienda
                </a>
            </div>
        </div>
    </div>
</x-public-layout>
