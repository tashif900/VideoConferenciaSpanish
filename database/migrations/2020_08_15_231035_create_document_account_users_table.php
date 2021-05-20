<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentAccountUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_account_users', function (Blueprint $table) {
            $table->id();
            $table->string('url_document');
            $table->unsignedBigInteger('document_account_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('document_account_id')->references('id')->on('document_accounts');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_account_users');
    }
}
