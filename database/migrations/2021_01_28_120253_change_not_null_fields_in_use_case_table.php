<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNotNullFieldsInUseCaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_case', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('accentureUsers')->nullable()->change();
            $table->string('clientUsers')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('use_case', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->string('accentureUsers')->nullable(false)->change();
            $table->string('clientUsers')->nullable(false)->change();
        });
    }
}
