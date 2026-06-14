<x-public-layout :store="$store">
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4" 
            x-data="{ show: true }" 
            x-show="show" 
            >
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
            >
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
    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('public.store.show', $store) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700">&larr; Volver a la tienda</a>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Mis Compras</h1>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-100 px-3 py-1 rounded-full">
                            {{ $orders->total() }} pedidos
                        </span>
                    </div>

                    @if($orders->isEmpty())
                        <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Aún no has hecho ninguna compra</h3>
                            <p class="text-gray-500 mb-6 text-sm">Explora nuestro catálogo y encuentra algo increíble para ti.</p>
                            <a href="{{ route('public.store.show', $store) }}" class="inline-flex px-8 py-3 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Ver Catálogo</a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <div class="group bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-indigo-100 transition-all duration-300">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center {{ $order->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                                @if($order->status === 'completed')
                                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                @else
                                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                @endif
                                            </div>
                                            
                                            <div>
                                                <h3 class="font-black text-gray-900 group-hover:text-indigo-600 transition">Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
                                                <div class="flex items-center gap-2 text-xs text-gray-500 font-medium">
                                                    <span>{{ $order->created_at->format('d M, Y') }}</span>
                                                    <span class="text-gray-300">•</span>
                                                    <span>{{ $order->items_count ?? $order->items->count() }} {{ Str::plural('producto', $order->items->count()) }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between sm:justify-end gap-6 border-t sm:border-t-0 pt-4 sm:pt-0">
                                            <div class="text-left sm:text-right">
                                                <p class="text-lg font-black text-gray-900">${{ number_format($order->total, 2) }}</p>
                                                <span class="inline-flex items-center text-[10px] font-black uppercase tracking-widest {{ $order->status === 'completed' ? 'text-emerald-600' : 'text-amber-600' }}">
                                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 animate-pulse {{ $order->status === 'completed' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                                    {{ $order->status === 'completed' ? 'Completado' : 'Pendiente' }}
                                                </span>
                                            </div>
                                            
                                            <a href="{{ route('public.customer.order', [$store, $order]) }}" class="bg-gray-50 text-gray-400 group-hover:bg-indigo-600 group-hover:text-white p-3 rounded-xl transition-all duration-300 shadow-sm">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Mis Datos de Contacto
                        </h3>

                        <form action="{{ route('public.customer.profile.update', $store) }}" method="POST" class="space-y-5">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Celular</label>
                                <div class="relative">
                                    <input type="text" name="phone" 
                                        value="{{ auth('customer')->user()->phone }}" 
                                        class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm py-3"
                                        placeholder="Ej: 987654321">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Dirección de Entrega</label>
                                <input type="text" name="address" 
                                    value="{{ auth('customer')->user()->address }}" 
                                    class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm py-3"
                                    placeholder="Calle, Número, Departamento...">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Referencias</label>
                                <textarea name="references" rows="3"
                                        class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm py-3"
                                        placeholder="Ej: Portón rojo, frente al parque...">{{ auth('customer')->user()->references }}</textarea>
                            </div>
                            
                            <div class="pt-2">
                                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100 active:scale-95">
                                    Actualizar Datos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
