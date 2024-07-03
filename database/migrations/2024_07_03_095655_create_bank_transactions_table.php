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
        Schema::dropIfExists('bank_transactions');

        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ledger_id')->nullable(false);
            $table->enum('entry_type', ['Dr', 'Cr'])->nullable()->default(null);
            $table->string('txn_type')->nullable()->default(null);
            $table->bigInteger('branch_id')->nullable()->default(null);
            $table->text('Note')->nullable();
            $table->decimal('amount', 10, 0)->nullable()->default(null);
            $table->string('cheque_no')->nullable()->default(null);
            $table->bigInteger('user_id')->nullable()->default(null);
            $table->bigInteger('client_id')->nullable()->default(null);
            $table->timestamp('date')->nullable()->default(null);
            $table->timestamp('cheque_date')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });

        // Add primary key
        Schema::table('bank_transactions', function (Blueprint $table) {
            $table->primary('id');
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
