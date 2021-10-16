<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderExtraFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_extra_fields', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order_id')->nullable();
            $table->string('name')->nullable();
            $table->string('value')->nullable();
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
        Schema::dropIfExists('purchase_order_extra_fields');
    }
}
