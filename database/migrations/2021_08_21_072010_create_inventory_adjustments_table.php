<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInventoryAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_adjustments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('date')->nullable();
            $table->string('ref')->nullable();
            $table->integer('ledger_id')->unsigned()->nullable()->index();
            $table->integer('reason_id')->unsigned()->nullable()->index();
            $table->string('description', 1000)->nullable();
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
        Schema::drop('inventory_adjustments');
    }
}
