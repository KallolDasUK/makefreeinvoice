<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('body')->nullable();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->boolean('seen')->default(false);
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
        Schema::drop('user_notifications');
    }
}
