<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteCascadeTouseCaseQuestionInUseCaseQuestionUseCaseTemplatePivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_case_question_use_case_template_pivots', function (Blueprint $table) {
            $table->dropForeign('ucq_id');
            $table->foreign('use_case_questions_id', 'ucq_id')
                ->references('id')->on('use_case_questions')
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
        Schema::table('use_case_question_use_case_template_pivots', function (Blueprint $table) {
            $table->dropForeign('ucq_id');
            $table->foreign('use_case_questions_id', 'ucq_id')
                ->references('id')->on('use_case_questions');
        });
    }
}
