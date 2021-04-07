<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('ledger_name')->nullable();
            $table->string('voucher_no')->nullable();
            $table->integer('branch_id')->unsigned()->nullable()->index();
            $table->float('amount')->nullable();
            $table->date('date')->nullable();
            $table->string('note', 1000)->nullable();
            $table->string('txn_type')->nullable();
            $table->string('type')->nullable();
            $table->integer('type_id')->unsigned()->nullable()->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
    }
}
