<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ledger_id');
            $table->string('entry_type', 255);
            $table->string('txn_type')->nullable();
            $table->bigInteger('branch_id');
            $table->text('note')->nullable();
            $table->decimal('amount', 10, 0)->nullable();
            $table->string('cheque_no')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->timestamp('date')->nullable();
            $table->timestamp('cheque_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_transactions');
    }
}
