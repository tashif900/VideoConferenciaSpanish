<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromotionalColumnsToMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->decimal('promotional_price',10,2)->nullable()->after('price');
            $table->date('promotion_start')->nullable()->after('promotional_price');
            $table->date('promotion_end')->nullable()->after('promotion_start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn('promotional_price');
            $table->dropColumn('promotion_start');
            $table->dropColumn('promotion_end');
        });
    }
}
