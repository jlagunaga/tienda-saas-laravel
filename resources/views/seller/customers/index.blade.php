<x-app-layout>
    <x-seller-store-header :store="$store" />
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Gestion de Clientes</h3>
                    </div>

                    @if($customers->isEmpty())
                        <div class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                            <p class="text-gray-500">Esta tienda aún no tiene clientes.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-3 border-b font-semibold text-gray-700 text-center">Nombre Cliente</th>
                                        <th class="p-3 border-b font-semibold text-gray-700 text-center">Email Cliente</th>
                                        <th class="p-3 border-b font-semibold text-gray-700 text-center">Total de Ordenes</th>
                                        <th class="p-3 border-b font-semibold text-gray-700 text-center">Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="p-3 border-b text-gray-800 text-center">{{ $customer->name }}</td>
                                            <td class="p-3 border-b text-gray-500 text-sm text-center">{{ $customer->email }}</td>
                                            <td class="p-3 border-b text-gray-500 text-sm text-center">{{ $customer->orders_count??'-' }}</td>
                                            <td class="p-3 border-b text-center">
                                                <div class="flex items-center justify-center space-x-3">
                                                    <a href="{{ route('stores.customers.show', [$store, $customer]) }}" class="inline-flex items-center px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-200 active:bg-indigo-300 focus:outline-none focus:border-indigo-300 focus:ring ring-indigo-200 disabled:opacity-25 transition ease-in-out duration-150">
                                                        Ver
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            {{ $customers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>