<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Este archivo configura tu aplicación Laravel, conectando las rutas web,
| API, consola y el endpoint de salud (health). Con esta configuración,
| Laravel cargará automáticamente las rutas en routes/api.php.
|
*/

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',          // rutas web
        api: __DIR__ . '/../routes/api.php',          // rutas API (👈 esta línea es la clave)
        commands: __DIR__ . '/../routes/console.php', // comandos artisan
        health: '/up',                                // ruta de salud
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Aquí puedes registrar middlewares globales o grupos adicionales si lo deseas.
        // Ejemplo:
        // $middleware->web(append: [
        //     \App\Http\Middleware\ExampleMiddleware::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Aquí puedes personalizar el manejo de excepciones
        // Ejemplo:
        // $exceptions->render(function (Throwable $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // });
    })
    ->create();
