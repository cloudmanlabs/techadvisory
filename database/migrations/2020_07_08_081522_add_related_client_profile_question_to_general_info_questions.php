<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelatedClientProfileQuestionToGeneralInfoQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_info_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('client_profile_question_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_info_questions', function (Blueprint $table) {
            $table->dropColumn('client_profile_question_id');
        });
    }
}
