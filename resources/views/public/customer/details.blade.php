<x-public-layout :store="$store">
    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('public.customer.dashboard', $store) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700">&larr; Volver a Mis Compras</a>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-6">
                <div class="flex items-center justify-between pb-6 border-b border-gray-100 mb-6">
                    <div>
                        <h1 class="text-2xl font-black text-gray-900">Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
                        <p class="text-sm text-gray-500 mt-1">Realizado el {{ $order->created_at->format('d de F, Y \a \l\a\s H:i') }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $order->status === 'completed' ? 'Completado' : 'Pendiente' }}
                    </span>
                </div>

                <div class="space-y-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400">Productos</h3>
                    <ul class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <li class="py-4 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                @if($item->product && $item->product->image_path)
                                    <div class="w-16 h-16 rounded-xl bg-gray-100 overflow-hidden">
                                        <img src="{{ asset('storage/' . $item->product->image_path) }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $item->product_name }}</p>
                                    <p class="text-xs text-gray-500">Cant: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-black text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-sm font-bold uppercase tracking-widest text-gray-400">Total</span>
                    <span class="text-3xl font-black text-indigo-600">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
