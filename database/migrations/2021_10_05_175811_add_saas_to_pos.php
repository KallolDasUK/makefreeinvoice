<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaasToPos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $saasTable = [
            'pos_sales',
            'pos_payments',
            'pos_items',
            'pos_charges',
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
        Schema::table('pos', function (Blueprint $table) {
            //
        });
    }
}
