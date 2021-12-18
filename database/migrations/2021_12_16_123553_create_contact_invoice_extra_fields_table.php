<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactInvoiceExtraFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_invoice_extra_fields', function (Blueprint $table) {
            $table->id();
            $table->string('contact_invoice_id')->nullable();
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
        Schema::dropIfExists('contact_invoice_extra_fields');
    }
}
