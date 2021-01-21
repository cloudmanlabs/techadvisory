<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReaddPracticeToUseCaseTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_case_templates', function (Blueprint $table) {
            $table->foreignId('practice_id')->nullable();
            $table->foreign('practice_id')
                ->references('id')->on('practices');

            $table->foreignId('subpractice_id')->nullable();
            $table->foreign('subpractice_id')
                ->references('id')->on('subpractices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('use_case_templates', function (Blueprint $table) {
            $table->dropForeign(['practice_id']);
            $table->dropColumn('practice_id');

            $table->dropForeign(['subpractice_id']);
            $table->dropColumn('subpractice_id');
        });
    }
}
