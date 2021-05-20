<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialNetworkUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_network_users', function (Blueprint $table) {
            $table->id();
            $table->string('value_social');
            $table->unsignedBigInteger('social_network_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('social_network_id')->references('id')->on('social_networks');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_network_users');
    }
}
