<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // SESUAI GAMBAR: Gunakan IsAdminMiddleware karena nama filenya begitu
            'is_admin' => \App\Http\Middleware\IsAdminMiddleware::class,

            // Ini middleware baru untuk Super Admin
            'is_superadmin' => \App\Http\Middleware\IsSuperAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions){
    })->create();
