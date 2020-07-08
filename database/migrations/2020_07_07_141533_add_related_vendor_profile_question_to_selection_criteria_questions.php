<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelatedVendorProfileQuestionToSelectionCriteriaQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selection_criteria_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_profile_question_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('selection_criteria_questions', function (Blueprint $table) {
            $table->dropColumn('vendor_profile_question_id');
        });
    }
}
