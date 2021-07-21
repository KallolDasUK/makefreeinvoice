<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\MetaSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Str;

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
        Paginator::useBootstrap();
        view()->composer('*', function ($view) {
            $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
            $view->with('settings', $settings);
        });

        Invoice::created(function ($invoice){
            $random = Str::random(40);

            $invoice->secret = $random;
        });


    }
}

