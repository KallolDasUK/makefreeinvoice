<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaasSystemToDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
            'categories',
            'products',
            'taxes',
            'extra_fields',
            'meta_settings',
            'receive_payments',
            'receive_payment_items'
        ];
        foreach ($saasTable as $tableName) {
            try {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->integer('user_id')->nullable();
                    $table->integer('client_id')->nullable();
                });
            }catch (\Exception $exception){

            }

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('database', function (Blueprint $table) {
            //
        });
    }
}
