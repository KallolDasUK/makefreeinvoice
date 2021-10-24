<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVendorAdvancePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_advance_payments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('vendor_id')->unsigned()->nullable()->index();
            $table->integer('ledger_id')->unsigned()->nullable()->index();
            $table->string('amount')->nullable();
            $table->string('date')->nullable();
            $table->string('note', 1000)->nullable();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('client_id')->unsigned()->nullable()->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vendor_advance_payments');
    }
}
