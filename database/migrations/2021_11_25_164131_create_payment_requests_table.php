<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_requests', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('date')->nullable();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('amount')->nullable();
            $table->string('status')->nullable();
            $table->string('note', 1000)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payment_requests');
    }
}
