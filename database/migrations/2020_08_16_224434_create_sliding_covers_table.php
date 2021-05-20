<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidingCoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliding_covers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('button_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->string('url_slider');
            $table->integer('position');
            $table->boolean('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliding_covers');
    }
}
