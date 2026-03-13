<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Rutas</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f3f4f6; }
        .card { background: white; padding: 2rem; border-radius: 1rem; shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #4f46e5; }
    </style>
</head>
<body>
    <div class="card">
        <h1>¡Ruta funcionando perfectamente!</h1>
        <p>Hola, <strong>{{ $nombre }}</strong>. Estás viendo una vista cargada desde una ruta.</p>
        <a href="{{ url('/') }}">Volver al inicio</a>
    </div>
</body>
</html>
