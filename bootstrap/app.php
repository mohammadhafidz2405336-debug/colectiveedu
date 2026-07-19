<?php

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
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
            'is_guru_bk' => \App\Http\Middleware\IsGuruBk::class,
            'is_admin_tu' => \App\Http\Middleware\IsAdminTu::class,
        ]);

        $middleware->redirectUsersTo(function (Request $request) {
            if (Auth::user()->role === 'admin_tu') return route('tu.dashboard');
            if (Auth::user()->role === 'guru_bk') return route('bk.dashboard');
            
            return route('dashboard');
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();