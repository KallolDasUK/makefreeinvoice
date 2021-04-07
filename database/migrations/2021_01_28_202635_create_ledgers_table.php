<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('ledger_name');
            $table->timestamps();
            $table->integer('ledger_group_id')->unsigned()->nullable()->index();
            $table->integer('opening')->nullable();
            $table->enum('opening_type', ['Dr', 'Cr'])->nullable();
            $table->enum('active', ['0', '1'])->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ledgers');
    }
}
