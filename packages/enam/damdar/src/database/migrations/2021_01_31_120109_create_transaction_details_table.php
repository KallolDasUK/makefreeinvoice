<?php

use Enam\Acc\Utils\EntryType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id')->nullable()->unsigned();
            $table->integer('ledger_id')->unsigned();
            $table->enum('entry_type', [EntryType::$DR, EntryType::$CR]);
            $table->string('note')->nullable();
            $table->float('amount')->nullable();
            $table->string('voucher_no')->nullable();
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
        Schema::dropIfExists('transaction_details');
    }
}
