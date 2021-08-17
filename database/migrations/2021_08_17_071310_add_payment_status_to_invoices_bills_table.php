<?php

use App\Models\Bill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentStatusToInvoicesBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('payment_status', [\App\Models\Invoice::Paid, \App\Models\Invoice::UnPaid, \App\Models\Invoice::Partial])->default(\App\Models\Invoice::UnPaid);
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->enum('payment_status', [Bill::Paid, Bill::UnPaid, Bill::Partial])->default(Bill::UnPaid);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices_bills', function (Blueprint $table) {
            //
        });
    }
}
