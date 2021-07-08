<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_type')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('sku', 255)->nullable();
            $table->string('photo')->nullable();
            $table->integer('category_id')->unsigned()->nullable()->index();
            $table->decimal('sell_price')->nullable();
            $table->string('sell_unit')->nullable();
            $table->decimal('purchase_price')->nullable();
            $table->string('purchase_unit')->nullable();
            $table->string('description', 1000)->nullable();
            $table->boolean('is_track')->nullable();
            $table->decimal('opening_stock')->nullable();
            $table->decimal('opening_stock_price')->nullable();
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
        Schema::drop('products');
    }
}
