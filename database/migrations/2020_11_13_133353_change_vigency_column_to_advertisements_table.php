<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVigencyColumnToAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->unsignedBigInteger('prices_advertisement_id')->nullable()->after('vigency');
            $table->decimal('price', 10,2)->nullable()->after('prices_advertisement_id');

            $table->foreign('prices_advertisement_id')->references('id')->on('prices_advertisements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropForeign(['prices_advertisement_id']);
            $table->dropColumn('prices_advertisement_id');
        });
    }
}
