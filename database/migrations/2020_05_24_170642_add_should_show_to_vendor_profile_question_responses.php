<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShouldShowToVendorProfileQuestionResponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_profile_question_responses', function (Blueprint $table) {
            // This should actually be validated or smth, but i'm actually stupid and this needs to be delivered tomorrow and
            // there is no time to rewrite the view components :)
            // i'll come around to fix it some time Kappa
            $table->boolean('shouldShow')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_profile_question_responses', function (Blueprint $table) {
            $table->dropColumn('shouldShow');
        });
    }
}
