<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactInvoicePaymentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_invoice_payment_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_invoice_payment_id')->nullable();
            $table->unsignedBigInteger('contact_invoice_id')->nullable();
            $table->decimal('amount', 12)->default(0)->nullable();
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
        Schema::dropIfExists('contact_invoice_payment_items');
    }
}
