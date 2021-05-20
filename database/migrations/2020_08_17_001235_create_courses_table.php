<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->integer('type_course')->comment('1.- Grabado 2.- Online');
            $table->integer('number_class');
            $table->double('price',10,2);
            $table->date('date_start');
            $table->string('photo');
            $table->string('url_presentation')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
