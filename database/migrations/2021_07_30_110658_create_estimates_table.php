<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('customer_id')->unsigned()->nullable()->index();
            $table->string('estimate_number')->nullable();
            $table->string('order_number')->nullable();
            $table->date('estimate_date')->nullable();
            $table->string('payment_terms')->nullable();
            $table->date('due_date')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('total')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_value')->nullable();
            $table->string('discount')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->text('terms_condition')->nullable();
            $table->text('notes')->nullable();
            $table->string('attachment')->nullable();
            $table->string('currency')->default('$');
            $table->date('shipping_date')->nullable();
            $table->string('secret')->nullable();
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
        Schema::dropIfExists('estimates');
    }
}
