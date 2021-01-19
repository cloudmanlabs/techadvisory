<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteCascadeToUseCaseQuestionResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_case_question_responses', function (Blueprint $table) {
            $table->dropForeign(['use_case_id']);
            $table->foreign('use_case_id')
                ->references('id')->on('use_case')
                ->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('use_case_question_responses', function (Blueprint $table) {
            $table->dropForeign(['use_case_id']);
            $table->foreign('use_case_id')->references('id')->on('use_case')->change();
        });
    }
}
