<x-app-layout>
<x-seller-store-header :store="$store" />


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Gestión de Categorías</h3>
                        <!-- Nota: Esta ruta falla hasta que creemos el método 'create' en el controlador -->
                        <a href="{{ route('stores.categories.create',$store)}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            + Nueva Categoría
                        </a>
                    </div>

                    @if($categories->isEmpty())
                        <div class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                            <p class="text-gray-500">Esta tienda aún no tiene categorías.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-3 border-b font-semibold text-gray-700">Nombre</th>
                                        <th class="p-3 border-b font-semibold text-gray-700">URL (Slug)</th>
                                        <th class="p-3 border-b font-semibold text-gray-700">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="p-3 border-b text-gray-800">{{ $category->name }}</td>
                                            <td class="p-3 border-b text-gray-500 text-sm">{{ $category->slug }}</td>
                                            <td class="p-3 border-b">
                                                <div class="flex items-center space-x-3">
                                                    <a href="{{route('stores.categories.edit',[$store,$category])}}" class="inline-flex items-center px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-200 active:bg-indigo-300 focus:outline-none focus:border-indigo-300 focus:ring ring-indigo-200 disabled:opacity-25 transition ease-in-out duration-150">
                                                        Editar
                                                    </a>
                                                    <form action="{{ route('stores.categories.destroy', [$store, $category]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 border border-transparent rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-200 active:bg-red-300 transition focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                            Borrar
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
