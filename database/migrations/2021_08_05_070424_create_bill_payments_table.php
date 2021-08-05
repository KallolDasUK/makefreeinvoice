<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->unsigned()->nullable()->index();
            $table->string('bill_id')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_sl')->nullable();
            $table->integer('payment_method_id')->unsigned()->nullable()->index();
            $table->string('ledger_id')->nullable();
            $table->string('note', 1000)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_payments');
    }
}
