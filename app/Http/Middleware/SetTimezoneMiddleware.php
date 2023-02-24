<?php

namespace App\Http\Middleware;

use App\Models\MetaSetting;
use App\Policies\BasePolicy;
use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class SetTimezoneMiddleware
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


        if (auth()->id()) {
            $settings = BasePolicy::getSettings();
            if ($settings->timezone ?? false) {
                config(['app.timezone' => $settings->timezone]);
                date_default_timezone_set($settings->timezone);
            }
        }

        return $next($request);
    }
}
