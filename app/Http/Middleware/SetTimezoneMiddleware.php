<?php

namespace App\Http\Middleware;

use App\Models\MetaSetting;
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
            $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
            if ($settings->timezone ?? false) {
                config(['app.timezone' => $settings->timezone]);
                date_default_timezone_set($settings->timezone);
            }
        }

        return $next($request);
    }
}
