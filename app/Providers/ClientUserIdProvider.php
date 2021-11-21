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
            'bills',
            'bill_items',
            'bill_extra_fields',
            'categories',
            'brands',
            'products',
            'product_units',
            'taxes',
            'extra_fields',
            'meta_settings',
            'receive_payments',
            'receive_payment_items',
            'bill_payments',
            'bill_payment_items',
            'expenses',
            'expense_items',
            'vendors',
            'reasons',
            'inventory_adjustments',
            'inventory_adjustment_items',
            'pos_sales',
            'pos_payments',
            'pos_items',
            'pos_charges',
            'purchase_orders',
            'purchase_order_items',
            'purchase_order_extra_fields',
            'sales_returns',
            'sales_return_items',
            'sales_return_extra_fields',
            'purchase_returns',
            'purchase_return_items',
            'purchase_return_extras',
            's_rs',
            'customer_advance_payments',
            'vendor_advance_payments',
            'productions',
            'production_items',
            'ingredient_items',
            'stock_entries',
            'stock_entry_items',
            'user_roles',
            'shortcuts'
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
//                    dump($className);
                }
            });


        }



    }
}
