<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda no encontrada - 404</title>
    <!-- Tailwind CSS CDN para renderizado rápido -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font Outfit para consistencia Premium -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-slate-100 shadow-xl text-center space-y-6">
        
        <!-- Icono 3D / Ilustrativo elegante -->
        <div class="w-20 h-20 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <div class="space-y-2">
            <!-- Título Principal -->
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">¿Te has perdido?</h1>
            <!-- Mensaje Descriptivo -->
            <p class="text-slate-500 text-sm leading-relaxed">
                La tienda que estás buscando no existe en nuestra plataforma, su enlace ha cambiado o está temporalmente inactiva.
            </p>
        </div>

        <!-- Botón de acción principal redirigiendo al dashboard o index -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-100 transition-all active:scale-95 cursor-pointer">
            Volver 
        </a>
        
        <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Plataforma Tienda SaaS</p>
    </div>
</body>
</html>
