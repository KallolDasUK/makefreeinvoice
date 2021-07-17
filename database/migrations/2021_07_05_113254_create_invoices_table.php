<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('customer_id')->unsigned()->nullable()->index();
            $table->string('invoice_number')->nullable();
            $table->string('order_number')->nullable();
            $table->date('invoice_date')->nullable();
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

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoices');
    }
}
