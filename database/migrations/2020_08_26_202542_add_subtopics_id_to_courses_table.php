<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubtopicsIdToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('subtopic_id');
            $table->foreign('subtopic_id')->references('id')->on('subtopics');

            $table->dropForeign(['thematic_id']);
            $table->dropColumn('thematic_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            //
            // $table->dropForeign('thematic_id');
            // $table->dropColumn('thematic_id');
        });
    }
}
