<?php

namespace App\Providers;

use App\Models\MetaSetting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
            $view->with('settings', $settings);
        });

    }
}

