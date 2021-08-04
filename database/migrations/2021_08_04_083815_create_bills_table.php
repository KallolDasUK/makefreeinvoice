<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->unsigned()->nullable()->index();
            $table->string('bill_number')->nullable();
            $table->string('order_number')->nullable();
            $table->date('bill_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('total')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_value')->nullable();
            $table->string('discount')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->text('notes')->nullable();
            $table->string('bill_status')->nullable();
            $table->string('attachment')->nullable();
            $table->string('secret')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('currency')->default('$');
            $table->unsignedBigInteger('bill_payment_id')->nullable();
            $table->boolean('is_payment')->default(false)->nullable();
            $table->decimal('payment_amount', 12)->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->integer('deposit_to')->nullable();
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
        Schema::dropIfExists('bills');
    }
}
