<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->date('birth_date')->nullable();
            $table->string('phone',255)->nullable();
            $table->string('grade',200)->nullable();
            $table->string('profession',200)->nullable();
            $table->longText('description')->nullable();
            $table->string('grade_instruction',255)->nullable();
            $table->string('name_institution',255)->nullable();
            $table->string('document_number',30)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('institution_type_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('document_type_id')->nullable();
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('institution_type_id')->references('id')->on('institution_types');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('document_type_id')->references('id')->on('document_types');
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
        Schema::dropIfExists('people');
    }
}
