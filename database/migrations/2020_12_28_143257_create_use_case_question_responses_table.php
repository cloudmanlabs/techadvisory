<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseCaseQuestionResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_case_question_responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('use_case_id')->nullable(false);
            $table->foreign('use_case_id')
                ->references('id')->on('use_case');

            $table->foreignId('use_case_questions_id')->nullable(false);
            $table->foreign('use_case_questions_id')
                ->references('id')->on('use_case_questions');

            $table->string('response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('use_case_question_responses');
    }
}
