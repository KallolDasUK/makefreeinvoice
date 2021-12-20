<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactInvoicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->unsigned()->nullable()->index();
            $table->string('contact_invoice_id')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_sl')->nullable();
            $table->integer('payment_method_id')->unsigned()->nullable()->index();
            $table->string('ledger_id')->nullable();
            $table->string('note', 1000)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->decimal('previous_due', 12)->default(0)->nullable();

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
        Schema::dropIfExists('contact_invoice_payments');
    }
}
