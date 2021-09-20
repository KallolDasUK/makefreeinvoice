<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserActive
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = \Auth::user();
            $user->last_active_at = date('Y-m-d H:i:s');
            $user->save();
        }
//        dd('test',auth()->check(),auth()->user(),$request->user());

        return $next($request);
    }
}
