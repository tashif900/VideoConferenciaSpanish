<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterWithdrawalPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdrawal_policies', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->string('start_day')->nullable()->change();
            $table->string('end_day')->nullable()->change();
            $table->double('amount_max')->after('end_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdrawal_policies', function (Blueprint $table) {
            //
        });
    }
}
