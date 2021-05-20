<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructor_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('period');
            $table->decimal('amount', 10,2);
            $table->decimal('platform_percentage', 10,2);
            $table->foreignId('class_id')->nullable()->constrained();
            $table->foreignId('course_id')->nullable()->constrained();
            $table->char('state', 1)->default();
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
        Schema::dropIfExists('instructor_movements');
    }
}
