<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_invoice_id');
            $table->unsignedBigInteger('product_id');
            $table->text('description')->nullable();
            $table->text('workers')->nullable();
            $table->decimal('monthly_cost')->default(0);
            $table->decimal('daily_cost')->default(0);
            $table->decimal('working_days')->default(0);
            $table->decimal('amount')->default(0);
            $table->decimal('tax_amount')->default(0);
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->decimal('total')->default(0);
            $table->date('date')->nullable();
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
        Schema::dropIfExists('contact_invoice_items');
    }
}
