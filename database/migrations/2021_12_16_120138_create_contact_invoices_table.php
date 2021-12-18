<?php

use App\Models\ContactInvoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->unsigned()->nullable()->index();
            $table->string('invoice_number')->nullable();
            $table->string('order_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('total')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_value')->nullable();
            $table->string('discount')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->text('notes')->nullable();
            $table->string('invoice_status')->nullable();
            $table->string('attachment')->nullable();
            $table->string('secret')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('currency')->default('$');
            $table->unsignedBigInteger('invoice_payment_id')->nullable();
            $table->boolean('is_payment')->default(false)->nullable();
            $table->decimal('payment_amount', 12)->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->integer('ledger_id')->nullable();
            $table->enum('payment_status', [ContactInvoice::Paid, ContactInvoice::UnPaid, ContactInvoice::Partial])->default(ContactInvoice::UnPaid);
            $table->decimal('from_advance', 12)->default(0)->nullable();

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
        Schema::dropIfExists('contact_invoices');
    }
}
