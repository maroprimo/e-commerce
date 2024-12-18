<?php

namespace App\Http\Middleware;

use Closure;

class Ip
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
        // dd($request->ip()); debug
        if($request->ip() != '::1'){
            return $next($request);
        }
        return response ('Unautorized', 401);
    }
}
