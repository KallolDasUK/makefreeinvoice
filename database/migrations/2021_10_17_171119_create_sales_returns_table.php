<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_returns', function (Blueprint $table) {
            $table->integer('customer_id')->unsigned()->nullable()->index();
            $table->string('invoice_number')->nullable();
            $table->string('sales_return_number')->nullable();
            $table->date('date')->nullable();
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
            $table->date('shipping_date')->nullable();

            $table->string('attachment')->nullable();

            $table->boolean('is_payment');
            $table->decimal('payment_amount', 12)->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->integer('deposit_to')->nullable();
            $table->unsignedBigInteger('receive_payment_id')->nullable();
            $table->string('invoice_status')->default('draft');
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
        Schema::dropIfExists('sales_returns');
    }
}
