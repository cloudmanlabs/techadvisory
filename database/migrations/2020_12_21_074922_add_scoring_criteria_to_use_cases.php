<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoringCriteriaToUseCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_cases', function (Blueprint $table) {
            $table->decimal('scoring_criteria', 5)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('use_cases', function (Blueprint $table) {
            $table->dropColumn('scoring_criteria');
        });
    }
}
