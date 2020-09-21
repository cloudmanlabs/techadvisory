<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTableAndForeignKeys extends Migration
{
    /**
     * Create table Owner an his dependences to project and user.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('owners')) {
            Schema::create('owners', function (Blueprint $table) {
                $table->id();
                $table->timestamps();

                $table->string('name');
            });
        }

        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'owner_id')) {
                $table->integer('owner_id')->nullable()->default(null)->change();
            } else {
                $table->integer('owner_id')->nullable()->default(null);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'owner_id')) {
                $table->integer('owner_id')->nullable()->default(null)->change();
            } else {
                $table->integer('owner_id')->nullable()->default(null);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owners');

        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'owner_id')) {
                $table->dropColumn('owner_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'owner_id')) {
                $table->dropColumn('owner_id');
            }
        });
    }
}
