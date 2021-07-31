<?php

namespace App\Providers;

use Enam\Acc\Models\LedgerGroup;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use App\Models;

class ClientUserIdProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $saasTable = [
            'ledger_groups',
            'ledgers',
            'group_maps',
            'branches',
            'transactions',
            'transaction_details',
            'settings',
            'customers',
            'invoice_extra_fields',
            'payment_methods',
            'invoices',
            'invoice_items',
            'estimates',
            'estimate_items',
            'estimate_extra_fields',

            'categories',
            'products',
            'taxes',
            'extra_fields',
            'meta_settings',
            'receive_payments',
            'receive_payment_items'
        ];
        foreach ($saasTable as $tableName) {
            $className = '\\App\\Models\\' . Str::studly(Str::singular($tableName));
            if (!class_exists($className)) {
                $className = 'Enam\\Acc\\Models\\' . Str::studly(Str::singular($tableName));
            }
            if (!class_exists($className)) return;

            $className::creating(function ($model) use ($className) {
                try {
                    $model->user_id = auth()->id();
                    $model->client_id = auth()->user()->client_id;
                } catch (\Exception $exception) {
                    dump($className);
                }
            });


        }

    }
}
