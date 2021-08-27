<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAmountBigInteger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

//        Schema::create('invoice_items', function (Blueprint $table) {
//            $table->string('amount')->default('0.00')->change();
//        });
//        Schema::create('bill_items', function (Blueprint $table) {
//            $table->string('amount')->default('0.00')->change();
//        });
//        Schema::create('estimate_items', function (Blueprint $table) {
//            $table->string('amount')->default('0.00')->change();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
