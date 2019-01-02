<?php

namespace App\Http\Middleware;

use Closure;

class PerfilHome
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
        if($request->session()->exists('perfil')){
            $request->session()->forget('perfil');
        }
        return $next($request);
    }
}
