<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configuración de la Tienda') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('stores.update', $store) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                @csrf
                @method('PUT')

                <!-- Panel Superior / Banner Preview -->
                <div class="relative h-64 bg-slate-100 border-b border-gray-100">
                    @if($store->banner_path)
                        <img src="{{ asset('storage/' . $store->banner_path) }}" alt="Banner" class="w-full h-full object-cover">
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-slate-400">
                            <svg class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <span class="text-sm font-semibold">Sin Banner Actual</span>
                        </div>
                    @endif
                    <!-- Input de Banner solapado -->
                    <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-4 py-2 rounded-xl shadow-lg border border-white/50">
                        <label class="text-xs font-bold text-gray-700 block mb-1">Actualizar Banner (Opcional)</label>
                        <input type="file" name="banner" class="text-xs text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
                        <x-input-error :messages="$errors->get('banner')" class="mt-1" />
                    </div>
                </div>

                <div class="p-8 md:p-12">
                    <!-- Fila Superior: Logo y Nombre -->
                    <div class="flex flex-col md:flex-row items-center gap-8 mb-10 pb-10 border-b border-gray-100">
                        <!-- Avatar / Logo -->
                        <div class="relative shrink-0">
                            <div class="w-32 h-32 rounded-full border-4 border-white shadow-xl overflow-hidden bg-white -mt-24 relative z-10 flex items-center justify-center">
                                @if($store->logo_path)
                                    <img src="{{ asset('storage/' . $store->logo_path) }}" alt="Logo" class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl font-black text-gray-200">{{ substr($store->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="text-xs font-bold text-gray-700 block mb-1 text-center">Subir Logo</label>
                                <input type="file" name="logo" class="w-full text-xs text-gray-500 file:mr-0 file:block file:w-full file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 file:text-center hover:file:bg-indigo-100" accept="image/*">
                                <x-input-error :messages="$errors->get('logo')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Nombre -->
                        <div class="flex-grow w-full">
                            <x-input-label for="name" value="Nombre de tu Tienda *" class="font-black text-gray-700" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-lg border-gray-200 focus:border-indigo-500 rounded-xl" :value="old('name', $store->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="text-xs text-indigo-500 font-mono mt-2">URL: {{ $store->slug }}.tu-dominio.com</p>
                        </div>
                    </div>

                    <!-- Grilla Principal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Columna Izquierda: Detalles Básicos -->
                        <div class="space-y-6">
                            <h3 class="text-sm font-black tracking-widest text-gray-400 uppercase mb-4">Ubicación y Perfil</h3>
                            
                            <div>
                                <x-input-label for="description" value="Acerca de nosotros" class="font-bold text-gray-700" />
                                <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm">{{ old('description', $store->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="address" value="Dirección Física (Opcional)" class="font-bold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </div>
                                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full pl-10 border-gray-200 rounded-xl" :value="old('address', $store->address)" placeholder="Ej: Av. Principal 123" />
                                </div>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        

                            <h3 class="text-sm font-black tracking-widest text-gray-400 uppercase mb-4">Datos bancarios</h3>
                            <div>
                                <x-input-label for="bank_name" value="Nombre del banco" class="font-bold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                        </svg>
                                    </div>
                                    <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full pl-10 border-gray-200 rounded-xl" :value="old('bank_name', $store->bank_name)" placeholder="Ej: Banco de Crédito" />
                                </div>
                                <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                            </div>
                        

                            <div>
                                <x-input-label for="bank_account" value="Numero de cuenta" class="font-bold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                        </svg>
                                    </div>
                                    <x-text-input id="bank_account" name="bank_account" type="text" class="mt-1 block w-full pl-10 border-gray-200 rounded-xl" :value="old('bank_account', $store->bank_account)" placeholder="Ej: 001-123456789" />
                                </div>
                                <x-input-error :messages="$errors->get('bank_account')" class="mt-2" />
                            </div>
                            
                            <div>
                                <x-input-label for="bank_cci" value="CCI" class="font-bold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                        </svg>
                                    </div>
                                    <x-text-input id="bank_cci" name="bank_cci" type="text" class="mt-1 block w-full pl-10 border-gray-200 rounded-xl" :value="old('bank_cci', $store->bank_cci)" placeholder="Ej: 001-123456789" />
                                </div>
                                <x-input-error :messages="$errors->get('bank_cci')" class="mt-2" />
                            </div>
                        
                            <div>
                                <x-input-label for="bank_holder" value="Nombre del Titular" class="font-bold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                        </svg>
                                    </div>
                                    <x-text-input id="bank_holder" name="bank_holder" type="text" class="mt-1 block w-full pl-10 border-gray-200 rounded-xl" :value="old('bank_holder', $store->bank_holder)" placeholder="Ej: 001-123456789" />
                                </div>
                                <x-input-error :messages="$errors->get('bank_holder')" class="mt-2" />
                            </div>
                            <!-- Celular e Imagen Yape -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="yape_phone" value="Número de Celular Yape" class="font-bold text-gray-700" />
                                    <x-text-input id="yape_phone" name="yape_phone" type="text" class="mt-1 block w-full border-gray-200 rounded-xl" :value="old('yape_phone', $store->yape_phone)" placeholder="Ej: 987654321" />
                                    <x-input-error :messages="$errors->get('yape_phone')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="yape_qr_path" value="QR de Yape" class="font-bold text-gray-700" />
                                    <div class="mt-1 relative">
                                        <input type="file" name="yape_qr_path" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">                                        
                                    </div>
                                    <x-input-error :messages="$errors->get('yape_qr_path')" class="mt-1" />                                
                                </div> 
                            </div>

                            <!-- Celular e Imagen Plin -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="plin_phone" value="Número de Celular Plin" class="font-bold text-gray-700" />
                                    <x-text-input id="plin_phone" name="plin_phone" type="text" class="mt-1 block w-full border-gray-200 rounded-xl" :value="old('plin_phone', $store->plin_phone)" placeholder="Ej: 987654321" />
                                    <x-input-error :messages="$errors->get('plin_phone')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="plin_qr_path" value="QR de Plin" class="font-bold text-gray-700" />
                                    <div class="mt-1 relative">
                                        <input type="file" name="plin_qr_path" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">                                        
                                    </div>
                                    <x-input-error :messages="$errors->get('plin_qr_path')" class="mt-1" />                                
                                </div> 
                            </div>


                            <div>
                                <x-input-label for="payment_instructions" value="Instrucciones de pago" class="font-bold text-gray-700" />
                                <div class="relative">
                                    <textarea id="payment_instructions" name="payment_instructions" type="text" class="mt-1 block w-full pl-10 border-gray-200 rounded-xl" :value="old('payment_instructions', $store->payment_instructions)" placeholder="Ej: instrucciones para ejecutar el pago" rows="4" ></textarea>
                                </div>
                                <x-input-error :messages="$errors->get('payment_instructions')" class="mt-2" />
                            </div>
                        </div>                        

                        <!-- Columna Derecha: Redes y Contacto -->
                        <div class="space-y-6">
                            <h3 class="text-sm font-black tracking-widest text-gray-400 uppercase mb-4">Contacto Inteligente</h3>
                            <!-- Correo de Notificaciones -->
                            <div>
                                <x-input-label for="contact_email" value="Correo de Notificaciones" class="font-bold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <x-text-input id="contact_email" name="contact_email" type="email" class="mt-1 block w-full pl-10 border-gray-200 rounded-xl" :value="old('contact_email', $store->contact_email)" placeholder="vendedor@ejemplo.com" />
                                </div>
                                <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                            </div>

                            <!-- Checkbox: Notificar Nuevos Pedidos -->
                            <div class="flex items-start bg-slate-50 p-4 rounded-xl border border-slate-100 mt-4">
                                <div class="flex items-center h-5">
                                    <!-- Mandamos 0 por defecto si no se marca para evitar problemas al desmarcar -->
                                    <input type="hidden" name="notify_new_order" value="0">
                                    <input id="notify_new_order" name="notify_new_order" type="checkbox" value="1"
                                        {{ old('notify_new_order', $store->notify_new_order) ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded shadow-sm">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="notify_new_order" class="font-bold text-slate-700 cursor-pointer">
                                        Notificar nuevos pedidos por correo
                                    </label>
                                    <p class="text-slate-500 text-xs mt-0.5">
                                        Recibe un email de aviso cada vez que un cliente realice una compra en tu tienda.
                                    </p>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="whatsapp_number" value="Número de WhatsApp" class="font-bold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </div>
                                    <x-text-input id="whatsapp_number" name="whatsapp_number" type="text" class="mt-1 block w-full pl-10 border-gray-200 rounded-xl" :value="old('whatsapp_number', $store->whatsapp_number)" placeholder="Ej: +51 987654321" />
                                </div>
                                <x-input-error :messages="$errors->get('whatsapp_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="facebook_url" value="Página de Facebook" class="font-bold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </div>
                                    <x-text-input id="facebook_url" name="facebook_url" type="url" class="mt-1 block w-full pl-10 border-gray-200 rounded-xl" :value="old('facebook_url', $store->facebook_url)" placeholder="https://facebook.com/tu-pagina" />
                                </div>
                                <x-input-error :messages="$errors->get('facebook_url')" class="mt-2" />
                            </div>
 
                            <div>
                                <x-input-label for="instagram_url" value="Perfil de Instagram" class="font-bold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                    </div>
                                    <x-text-input id="instagram_url" name="instagram_url" type="url" class="mt-1 block w-full pl-10 border-gray-200 rounded-xl" :value="old('instagram_url', $store->instagram_url)" placeholder="https://instagram.com/tu-perfil" />
                                </div>
                                <x-input-error :messages="$errors->get('instagram_url')" class="mt-2" />
                            </div>
                        </div>

                    </div>

                    <!-- Botón Guardar -->
                    <div class="mt-10 pt-8 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-transform active:scale-95">
                            Guardar Cambios
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
