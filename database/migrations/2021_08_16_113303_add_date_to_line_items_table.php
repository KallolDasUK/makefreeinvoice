<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateToLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->date('date')->nullable();
        });
        Schema::table('estimate_items', function (Blueprint $table) {
            $table->date('date')->nullable();
        });
        Schema::table('bill_items', function (Blueprint $table) {
            $table->date('date')->nullable();
        });
        Schema::table('expense_items', function (Blueprint $table) {
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
