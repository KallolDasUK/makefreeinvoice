<?php

namespace Enam\Acc;


use Enam\Acc\Http\Livewire\AccHeadComponent;
use Enam\Acc\Http\Livewire\EarnExpenseComponent;
use Enam\Acc\Http\Livewire\LedgerComponent;
use Enam\Acc\Http\Livewire\TrialBalanceComponent;
use Enam\Acc\Http\Livewire\VoucherEntryComponent;
use Enam\Acc\Models\Setting;
use Enam\Acc\Models\TransactionDetail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AccountingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {



        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'accounting');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'acc');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('accounting.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/database/migrations' => database_path('/migrations/'),
            ], 'migrations');

            $this->publishes([
                __DIR__ . '/database/seeders' => database_path('/seeders/'),
            ], 'seed');

            $this->publishes([
                __DIR__ . '/resources/assets' => public_path('acc'),
            ], 'assets');


        }

        TransactionDetail::created(function ($model) {
            $model->date = $model->transaction->date;
            if ($model->transaction_id) {
                $model->branch_id = $model->transaction->branch_id;
            }

            $model->save();
        });
        if (Schema::hasTable('settings')) {
            $settings = Setting::query()->get()->count();
            if (!$settings) {
                Setting::create(['name' => 'Business Name', 'address' => 'Address',
                    'phone' => '+880123456789', 'email' => 'test@gmail.com']);
            }
        }
        View::composer('*', function ($view) {
            $settings = Setting::query()->first();
            $view->with('settings', $settings);
        });


    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'accounting');

        $this->app->singleton('accounting', function () {
            return new Accounting;
        });


    }
}
