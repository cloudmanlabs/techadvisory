<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordResetToCredentials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_credentials', function (Blueprint $table) {
            $table->string('password')->nullable()->change();

            $table->string('passwordChangeToken')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_credentials', function (Blueprint $table) {
            $table->string('password')->nullable(false)->change();

            $table->dropColumn('passwordChangeToken');
        });
    }
}
