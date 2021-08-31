<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        //se o usuario for admin podera prosseguir para ação
        if($request->user()->admin)
        {
            return $next($request);
        }
        return response()->json('Essa ação requer permissão de administrador.', 401);
    }
}
