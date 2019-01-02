<?php

namespace App\Http\Middleware;

use Closure;

class PerfilConsumidor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        session(['perfil' => 'consumidor']);
        return $next($request);
    }
}
