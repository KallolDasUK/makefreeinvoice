<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterCustomerAdvancePayments1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_advance_payments', function(Blueprint $table)
        {
            $table->integer('ledger_id')->unsigned()->nullable()->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_advance_payments', function(Blueprint $table)
        {
            $table->dropColumn('ledger_id');

        });
    }
}
