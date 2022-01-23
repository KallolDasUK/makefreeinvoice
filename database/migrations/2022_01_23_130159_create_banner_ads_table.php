<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannerAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_ads', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('title', 255)->nullable();
            $table->string('photo')->nullable();
            $table->string('link')->nullable();
            $table->string('banner_type')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('banner_ads');
    }
}
