<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
{
    /** @var \Illuminate\Contracts\Auth\Guard $auth */
    $auth = auth();
    
    if ($auth->check() && $auth->user()->role === 'admin') {
        return $next($request);
    }

    return redirect(to: '/')->with(key: 'error', value: 'Akses ditolak! Kamu bukan admin.');
}
}