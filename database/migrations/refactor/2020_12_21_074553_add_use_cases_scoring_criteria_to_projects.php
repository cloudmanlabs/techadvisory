<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUseCasesScoringCriteriaToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('use_case_rfp', 5)->nullable()->default(null);
            $table->decimal('use_case_solution_fit', 5)->nullable()->default(null);
            $table->decimal('use_case_usability', 5)->nullable()->default(null);
            $table->decimal('use_case_performance', 5)->nullable()->default(null);
            $table->decimal('use_case_look_feel', 5)->nullable()->default(null);
            $table->decimal('use_case_others', 5)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('use_case_rfp');
            $table->dropColumn('use_case_solution_fit');
            $table->dropColumn('use_case_usability');
            $table->dropColumn('use_case_performance');
            $table->dropColumn('use_case_look_feel');
            $table->dropColumn('use_case_others');
        });
    }
}
