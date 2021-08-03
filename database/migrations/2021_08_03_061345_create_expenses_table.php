<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('date')->nullable();
            $table->integer('ledger_id')->unsigned()->nullable()->index();
            $table->integer('vendor_id')->unsigned()->nullable()->index();
            $table->integer('customer_id')->unsigned()->nullable()->index();
            $table->string('ref')->nullable();
            $table->boolean('is_billable')->nullable();
            $table->string('file')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('client_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('expenses');
    }
}
