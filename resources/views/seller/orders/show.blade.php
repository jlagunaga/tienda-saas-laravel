<x-app-layout>
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Gestion de Ordenes</h3>
                    </div>

                    @if($orders->isEmpty())
                        <div class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                            <p class="text-gray-500">Esta tienda aún no tiene ordenes.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-3 border-b font-semibold text-gray-700">Nombre Cliente</th>
                                        <th class="p-3 border-b font-semibold text-gray-700">Email Cliente</th>
                                        <th class="p-3 border-b font-semibold text-gray-700">Total</th>
                                        <th class="p-3 border-b font-semibold text-gray-700">Estado</th>
                                        <th class="p-3 border-b font-semibold text-gray-700">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="p-3 border-b text-gray-800">{{ $order->customer_name }}</td>
                                            <td class="p-3 border-b text-gray-500 text-sm">{{ $order->customer_email }}</td>
                                            <td class="p-3 border-b text-gray-500 text-sm">{{ $order->total }}</td>
                                            <td class="p-3 border-b">
                                                @if($order->status == 'pending')
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                                        Pendiente
                                                    </span>
                                                @elseif($order->status == 'completed')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                                        Completado
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                                        {{ $order->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="p-3 border-b">
                                                <div class="flex items-center space-x-3">
                                                    <a href="{{route('stores.orders.details',$order)}}" class="inline-flex items-center px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-200 active:bg-indigo-300 focus:outline-none focus:border-indigo-300 focus:ring ring-indigo-200 disabled:opacity-25 transition ease-in-out duration-150">
                                                        Ver
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>