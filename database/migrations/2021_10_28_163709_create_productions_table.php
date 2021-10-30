<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('ref')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->nullable();
            $table->string('note', 1000)->nullable();
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
        Schema::drop('productions');
    }
}
