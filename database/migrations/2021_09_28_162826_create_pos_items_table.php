<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pos_sales_id');
            $table->unsignedBigInteger('product_id');
            $table->string('price')->nullable();
            $table->string('qnt')->nullable();
            $table->string('amount')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->unsignedBigInteger('attribute_id')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('pos_items');
    }
}
