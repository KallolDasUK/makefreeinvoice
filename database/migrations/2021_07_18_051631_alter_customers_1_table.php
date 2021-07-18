<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterCustomers1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function(Blueprint $table)
        {
            $table->string('country', 191)->nullable();
            $table->string('street_1', 191)->nullable();
            $table->string('street_2', 191)->nullable();
            $table->string('city', 191)->nullable();
            $table->string('state', 191)->nullable();
            $table->string('zip_post', 191)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function(Blueprint $table)
        {
            $table->dropColumn('country');
            $table->dropColumn('street_1');
            $table->dropColumn('street_2');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('zip_post');

        });
    }
}
