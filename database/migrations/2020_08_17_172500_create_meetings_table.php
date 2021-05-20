<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->integer('type_meeting')->comment('1-Uno a Uno, 2- Uno a Varios');
            $table->integer('number_participant')->nullable();
            $table->double('price',10,2);
            $table->dateTime('hour_start');
            $table->dateTime('hour_end');
            $table->string('url_room')->nullable();
            $table->string('room_password')->nullable();
            $table->string('room_name')->nullable();
            $table->string('room_id')->nullable();
            $table->boolean('state');
            $table->unsignedBigInteger('thematic_id');
            $table->foreign('thematic_id')->references('id')->on('thematics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
