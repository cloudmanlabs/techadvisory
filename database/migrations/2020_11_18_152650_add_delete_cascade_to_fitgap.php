<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteCascadeToFitgap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fitgap_vendor_responses', function (Blueprint $table) {
            $table->dropForeign(['fitgap_question_id']);
            $table->foreign('fitgap_question_id')
                ->references('id')->on('fitgap_questions')
                ->onDelete('cascade')->change();

            $table->dropForeign(['vendor_application_id']);
            $table->foreign('vendor_application_id')
                ->references('id')->on('vendor_applications')
                ->onDelete('cascade')->change();
        });

        Schema::table('fitgap_questions', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->foreign('project_id')
                ->references('id')->on('projects')
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
        Schema::table('fitgap_vendor_responses', function (Blueprint $table) {

            $table->foreign('fitgap_question_id')->references('id')->on('fitgap_questions')->change();
            $table->foreign('vendor_application_id')->references('id')->on('vendor_applications')->change();

        });

        Schema::table('fitgap_questions', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')->change();

        });


    }
}
