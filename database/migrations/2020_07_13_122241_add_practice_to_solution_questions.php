<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPracticeToSolutionQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_solution_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('practice_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_solution_questions', function (Blueprint $table) {
            $table->dropColumn('practice_id');
        });
    }
}
