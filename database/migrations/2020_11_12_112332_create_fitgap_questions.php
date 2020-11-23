<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFitgapQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fitgap_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('project_id');
            $table->unsignedBigInteger('position')->nullable();     //utils

            // Excel columns
            $table->string('requirement_type')->nullable();
            $table->text('level_1')->nullable();
            $table->text('level_2')->nullable();
            $table->text('level_3')->nullable();
            $table->text('requirement');

            // Client columns
            $table->text('client')->nullable();
            $table->text('business_opportunity')->nullable();

            $table->foreign('project_id')->references('id')->on('projects');
        });

        Schema::create('fitgap_vendor_responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('fitgap_question_id');
            $table->foreignId('vendor_application_id');

            $table->text('response')->nullable();
            $table->text('comments')->nullable();

            $table->foreign('fitgap_question_id')->references('id')->on('fitgap_questions');
            $table->foreign('vendor_application_id')->references('id')->on('vendor_applications');

        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fitgap_vendor_responses');
        Schema::dropIfExists('fitgap_questions');
    }
}
