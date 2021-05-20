<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_policies', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('start_day');
            $table->string('end_day');
            $table->char('state', 1)->default(1);
            $table->unsignedBigInteger('user_create');
            $table->unsignedBigInteger('user_update');
            $table->timestamps();

            $table->foreign('user_create')->references('id')->on('users');
            $table->foreign('user_update')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawal_policies');
    }
}
