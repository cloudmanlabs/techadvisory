<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateUseCaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('use_case_question_responses', function (Blueprint $table) {
//            $table->dropForeign(['use_case_id']);
//            $table->foreign('use_case_id')->references('id')->on('use_case')->change();
//        });
//
//        Schema::table('use_case_question_use_case_template_pivots', function (Blueprint $table) {
//            $table->dropForeign('uct_id');
//            $table->foreign('use_case_templates_id', 'uct_id')->references('id')->on('use_case_templates')->change();
//        });
//
//        Schema::table('use_case', function (Blueprint $table) {
//            $table->dropForeign(['template_id']);
//            $table->foreign('template_id')->references('id')->on('use_case_templates')->change();
//        });
//
//        Schema::table('use_case_questions', function (Blueprint $table) {
//            $table->dropColumn('options');
//        });
//
//        Schema::table('use_case_questions', function (Blueprint $table) {
//            $table->dropColumn('presetOption');
//        });
//
//        Schema::table('use_case_questions', function (Blueprint $table) {
//            $table->dropColumn('placeholder');
//        });
//
//        Schema::table('use_case', function (Blueprint $table) {
//            $table->dropForeign(['template_id']);
//        });
//
//        Schema::dropIfExists('use_case_question_use_case_template_pivots');
//
//        Schema::dropIfExists('use_case_question_responses');
//
//        Schema::dropIfExists('use_case_questions');
//
//        Schema::dropIfExists('use_case_templates');
//
//        Schema::table('projects', function (Blueprint $table) {
//            $table->dropColumn('use_case_invited_vendors');
//        });
//
//        Schema::table('use_case', function (Blueprint $table) {
//            $table->dropColumn('scoring_criteria');
//        });
//
//        Schema::table('projects', function (Blueprint $table) {
//            $table->dropColumn('use_case_rfp');
//            $table->dropColumn('use_case_solution_fit');
//            $table->dropColumn('use_case_usability');
//            $table->dropColumn('use_case_performance');
//            $table->dropColumn('use_case_look_feel');
//            $table->dropColumn('use_case_others');
//        });
//
//        Schema::dropIfExists('use_case');
//
//        Schema::table('projects', function (Blueprint $table) {
//            $table->dropColumn('useCases');
//        });
        //--------------------------------------------------------------------------------------------------------------

//        Schema::table('projects', function (Blueprint $table) {
//            $table->string('useCases')->default('no');
//            $table->string('useCasesPhase')->default('setup');
//            $table->decimal('use_case_rfp', 5)->nullable()->default(null);
//            $table->decimal('use_case_solution_fit', 5)->nullable()->default(null);
//            $table->decimal('use_case_usability', 5)->nullable()->default(null);
//            $table->decimal('use_case_performance', 5)->nullable()->default(null);
//            $table->decimal('use_case_look_feel', 5)->nullable()->default(null);
//            $table->decimal('use_case_others', 5)->nullable()->default(null);
//            $table->string('use_case_invited_vendors')->nullable()->default(null);
//        });
//
//        Schema::create('use_case', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//
//            $table->string('name')->nullable(false);
//            $table->text('description')->nullable(false);
//
//            $table->foreignId('practice_id')->nullable(false);
//            $table->foreign('practice_id')
//                ->references('id')->on('practices');
//
//            $table->foreignId('project_id')->nullable(false);
//            $table->foreign('project_id')
//                ->references('id')->on('projects')
//                ->onDelete('cascade');
//
//            $table->string('accentureUsers');
//            $table->string('clientUsers');
//
//            $table->decimal('scoring_criteria', 5)->nullable()->default(null);
//        });
//
//        Schema::create('use_case_templates', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//            $table->string('name')->nullable(false);
//            $table->text('description')->nullable(false);
//            $table->foreignId('practice_id')->nullable(false);
//            $table->foreign('practice_id')
//                ->references('id')->on('practices');
//        });
//
//        Schema::create('use_case_questions', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//
//            $table->string('label')->nullable(false);
//            $table->string('type')->nullable(false);
//            $table->boolean('required')->nullable(false);
//
//            $table->foreignId('practice_id')->nullable(false);
//            $table->foreign('practice_id')->nullable(true)
//                ->references('id')->on('practices');
//
//            $table->string('placeholder')->nullable();
//            $table->string('presetOption')->nullable();
//            $table->text('options')->nullable();
//        });
//
//        Schema::create('use_case_question_responses', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//
//            $table->foreignId('use_case_id')->nullable(false);
//            $table->foreign('use_case_id')
//                ->references('id')->on('use_case')
//                ->onDelete('cascade')->change();
//
//            $table->foreignId('use_case_questions_id')->nullable(false);
//            $table->foreign('use_case_questions_id')
//                ->references('id')->on('use_case_questions');
//
//            $table->text('response')->nullable();
//        });
//
//        Schema::create('use_case_templates_question_responses', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//
//            $table->foreignId('use_case_templates_id')->nullable(false);
//            $table->foreign('use_case_templates_id', 'ucti')
//                ->references('id')->on('use_case_templates')
//                ->onDelete('cascade')->change();
//
//            $table->foreignId('use_case_questions_id')->nullable(false);
//            $table->foreign('use_case_questions_id', 'ucqi')
//                ->references('id')->on('use_case_questions');
//
//            $table->text('response')->nullable();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

//        Schema::dropIfExists('use_case_templates_question_responses');
//
//        Schema::dropIfExists('use_case_question_responses');
//
//        Schema::dropIfExists('use_case_questions');
//
//        Schema::dropIfExists('use_case_templates');
//
//        Schema::dropIfExists('use_case');
//
//        Schema::table('projects', function (Blueprint $table) {
//            $table->dropColumn('useCases');
//            $table->dropColumn('useCasesPhase');
//            $table->dropColumn('use_case_rfp');
//            $table->dropColumn('use_case_solution_fit');
//            $table->dropColumn('use_case_usability');
//            $table->dropColumn('use_case_performance');
//            $table->dropColumn('use_case_look_feel');
//            $table->dropColumn('use_case_others');
//            $table->dropColumn('use_case_invited_vendors');
//        });

        //--------------------------------------------------------------------------------------------------------------

//        Schema::table('projects', function (Blueprint $table) {
//            $table->string('useCases')->default('no');
//            $table->decimal('use_case_rfp', 5)->nullable()->default(null);
//            $table->decimal('use_case_solution_fit', 5)->nullable()->default(null);
//            $table->decimal('use_case_usability', 5)->nullable()->default(null);
//            $table->decimal('use_case_performance', 5)->nullable()->default(null);
//            $table->decimal('use_case_look_feel', 5)->nullable()->default(null);
//            $table->decimal('use_case_others', 5)->nullable()->default(null);
//            $table->string('use_case_invited_vendors')->nullable()->default(null);
//        });
//
//        Schema::create('use_case', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//
//            $table->string('name')->nullable(false);
//            $table->text('description')->nullable(false);
//
//            $table->foreignId('practice_id')->nullable(false);
//            $table->foreign('practice_id')
//                ->references('id')->on('practices')
//                ->onDelete('cascade');
//
//            $table->foreignId('project_id')->nullable(false);
//            $table->foreign('project_id')
//                ->references('id')->on('projects')
//                ->onDelete('cascade');
//
//            $table->string('accentureUsers');
//            $table->string('clientUsers');
//
//            $table->decimal('scoring_criteria', 5)->nullable()->default(null);
//        });
//
//        Schema::create('use_case_templates', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//            $table->string('name')->nullable(false);
//            $table->text('description')->nullable(false);
//            $table->foreignId('practice_id')->nullable(false);
//            $table->foreign('practice_id')
//                ->references('id')->on('practices')
//                ->onDelete('cascade');
//        });
//
//        Schema::table('use_case', function (Blueprint $table) {
//            $table->foreignId('template_id')->nullable(false);
//            $table->foreign('template_id')
//                ->references('id')->on('use_case_templates');
//        });
//
//        Schema::create('use_case_questions', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//
//            $table->string('label')->nullable(false);
//            $table->string('type')->nullable(false);
//            $table->boolean('required')->nullable(false);
//            $table->text('options')->nullable();
//            $table->string('presetOption')->nullable();
//            $table->string('placeholder')->nullable();
//        });
//
//        Schema::create('use_case_question_responses', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//
//            $table->foreignId('use_case_id')->nullable(false);
//            $table->foreign('use_case_id')
//                ->references('id')->on('use_case')
//                ->onDelete('cascade');
//
//            $table->foreignId('use_case_questions_id')->nullable(false);
//            $table->foreign('use_case_questions_id')
//                ->references('id')->on('use_case_questions')
//                ->onDelete('cascade');
//
//            $table->text('response');
//        });
//
//        Schema::create('use_case_question_use_case_template_pivots', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//
//            $table->foreignId('use_case_templates_id')->nullable(false);
//            $table->foreign('use_case_templates_id', 'uct_id')
//                ->references('id')->on('use_case_templates')
//                ->onDelete('cascade');
//
//            $table->foreignId('use_case_questions_id')->nullable(false);
//            $table->foreign('use_case_questions_id', 'ucq_id')
//                ->references('id')->on('use_case_questions');
//        });

    }
}
