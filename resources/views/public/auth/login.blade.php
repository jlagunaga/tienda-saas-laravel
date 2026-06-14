<x-public-layout :store="$store">
    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50/50">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-[2.5rem] shadow-xl shadow-indigo-100/50 border border-gray-100">
            <div>
                <h2 class="text-center text-3xl font-black text-gray-900 tracking-tight">
                    ¡Bienvenido de nuevo!
                </h2>
                <p class="mt-2 text-center text-sm text-gray-500">
                    Ingresa a tu cuenta en <span class="font-bold text-indigo-600">{{ $store->name }}</span>
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('public.store.login', $store) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1 ml-1">Correo Electrónico</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" class="appearance-none relative block w-full px-4 py-3 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="tu@email.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1 ml-1">Contraseña</label>
                        <input id="password" name="password" type="password" required class="appearance-none relative block w-full px-4 py-3 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-500">Recordarme</label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-black rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all active:scale-95 shadow-lg shadow-indigo-200">
                        Entrar
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-500">
                        ¿No tienes cuenta? 
                        <a href="{{ route('public.store.register', $store) }}" class="font-bold text-indigo-600 hover:text-indigo-500">Regístrate gratis</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>
