<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientIdToSrsTable extends Migration
{

    public function up()
    {
        Schema::table('s_rs', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }


    public function down()
    {
        Schema::table('s_rs', function (Blueprint $table) {
            //
        });
    }
}
