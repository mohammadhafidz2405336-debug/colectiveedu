<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdminTu
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    if (Auth::check() && Auth::user()->role === 'admin_tu') {
        return $next($request);
    }
    return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
    }
}
