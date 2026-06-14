<x-public-layout :store="$store">
    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50/50">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-[2.5rem] shadow-xl shadow-indigo-100/50 border border-gray-100">
            <div>
                <h2 class="text-center text-3xl font-black text-gray-900 tracking-tight">
                    Crea tu cuenta
                </h2>
                <p class="mt-2 text-center text-sm text-gray-500">
                    Únete a la comunidad de <span class="font-bold text-indigo-600">{{ $store->name }}</span>
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('public.store.register', $store) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1 ml-1">Nombre Completo</label>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}" class="appearance-none relative block w-full px-4 py-3 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="Ej. Juan Pérez">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1 ml-1">Correo Electrónico</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" class="appearance-none relative block w-full px-4 py-3 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="tu@email.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1 ml-1">Telefono</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="appearance-none relative block w-full px-4 py-3 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="3475-598563">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="address" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1 ml-1">Direccion</label>
                        <input id="address" name="address" type="text" value="{{ old('address') }}" class="appearance-none relative block w-full px-4 py-3 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="3475-598563">
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="references" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1 ml-1">Referencias</label>
                        <input id="references" name="references" type="text" value="{{ old('references') }}" class="appearance-none relative block w-full px-4 py-3 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="3475-598563">
                        @error('references') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1 ml-1">Contraseña</label>
                        <input id="password" name="password" type="password" required class="appearance-none relative block w-full px-4 py-3 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="••••••••">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1 ml-1">Confirmar Contraseña</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none relative block w-full px-4 py-3 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-black rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all active:scale-95 shadow-lg shadow-indigo-200">
                        Registrarme
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-500">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('public.store.login', $store) }}" class="font-bold text-indigo-600 hover:text-indigo-500">Inicia sesión aquí</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>
