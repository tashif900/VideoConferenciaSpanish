<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->double('price',10,2)->nullable();
            $table->dateTime('hour_start');
            $table->dateTime('hour_end');
            $table->string('photo',200)->nullable();
            $table->string('url_presentation')->nullable();
            $table->string('url_video')->nullable();
            $table->string('url_room')->nullable();
            $table->string('room_password')->nullable();
            $table->string('room_name')->nullable();
            $table->string('room_id')->nullable();
            $table->integer('type_class')->comment('1.-Grabado, 2.-Online');
            $table->boolean('state');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('thematic_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses');
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
        Schema::dropIfExists('course_classes');
    }
}
