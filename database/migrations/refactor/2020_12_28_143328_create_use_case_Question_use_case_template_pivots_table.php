<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseCaseQuestionUseCaseTemplatePivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_case_question_use_case_template_pivots', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('use_case_templates_id')->nullable(false);
            $table->foreign('use_case_templates_id', 'uct_id')
                ->references('id')->on('use_case_templates');

            $table->foreignId('use_case_questions_id')->nullable(false);
            $table->foreign('use_case_questions_id', 'ucq_id')
                ->references('id')->on('use_case_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('use_case_question_use_case_template_pivots');
    }
}
