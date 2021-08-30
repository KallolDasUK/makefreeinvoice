<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsMasterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        abort_if(auth()->user()->role != 'master', 403, 'You are not master.');
        return $next($request);
    }
}
