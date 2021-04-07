<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLedgerGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('group_name');
            $table->integer('parent');
            $table->enum('nature', ['Asset', 'Liabilities', 'Income', 'Expense'])->nullable();
            $table->enum('cashflow_type', ['Operating Activities', 'Investing Activities', 'Financial Activities'])->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ledger_groups');
    }
}
