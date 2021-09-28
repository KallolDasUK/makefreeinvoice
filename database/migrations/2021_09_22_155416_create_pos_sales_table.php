<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePosSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_sales', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('pos_number')->nullable();
            $table->string('date')->nullable();
            $table->integer('customer_id')->unsigned()->nullable()->index();
            $table->integer('branch_id')->unsigned()->nullable()->index();
            $table->integer('ledger_id')->unsigned()->nullable()->index();
            $table->string('note', 1000)->nullable();
            $table->integer('payment_method_id')->unsigned()->nullable()->index();
            $table->string('sub_total')->nullable();
            $table->string('total')->nullable();
            $table->string('pos_status')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pos_sales');
    }
}
