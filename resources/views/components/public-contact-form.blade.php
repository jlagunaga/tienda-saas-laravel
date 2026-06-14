<!-- ========================================== -->
<!-- BOTÓN FLOTANTE Y MODAL DE CONTACTO         -->
<!-- ========================================== -->
<!-- Nota: Si hay errores de validación, el modal se mantendrá abierto automáticamente -->
<div x-data="{ openContactModal: {{ $errors->any() ? 'true' : 'false' }} }">
    
    <!-- Botón Flotante (Fijo en la esquina inferior derecha) -->
    <button @click="openContactModal = true" class="fixed bottom-6 right-6 md:bottom-10 md:right-10 bg-gray-900 text-white p-4 rounded-full shadow-2xl hover:bg-indigo-600 hover:scale-110 transition-all duration-300 z-40 group flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-300 ease-in-out font-bold text-sm">
            Escríbenos
        </span>
    </button>

    <!-- Modal Alpine.js -->
    <div x-show="openContactModal" 
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
         
        <!-- Fondo oscuro difuminado (Overlay) -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="openContactModal = false"></div>

        <!-- Contenedor del Formulario -->
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95">
             
            <!-- Encabezado del Modal -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 flex-shrink-0">
                <div>
                    <h3 class="text-lg font-black text-gray-900">Enviar mensaje</h3>
                    <p class="text-xs text-gray-500 font-medium">Nos pondremos en contacto contigo pronto.</p>
                </div>
                <button @click="openContactModal = false" class="text-gray-400 hover:text-rose-500 hover:bg-rose-50 p-2 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Cuerpo del Modal (Formulario con scroll) -->
            <div class="p-6 sm:p-8 overflow-y-auto">
                <form action="{{ route('public.store.contact', $store) }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nombre <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" required class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" required class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Teléfono (Opcional)</label>
                            <input type="tel" name="phone" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Asunto <span class="text-rose-500">*</span></label>
                            <input type="text" name="subject" required class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Mensaje <span class="text-rose-500">*</span></label>
                        <textarea name="message" rows="4" required class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-xl font-bold hover:bg-indigo-600 transition-colors flex justify-center items-center gap-2 group">
                        Enviar Consulta
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
