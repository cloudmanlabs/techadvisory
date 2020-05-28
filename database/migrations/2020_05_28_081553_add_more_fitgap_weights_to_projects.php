<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFitgapWeightsToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedInteger('fitgapFunctionalWeight')->default(60);
            $table->unsignedInteger('fitgapTechnicalWeight')->default(20);
            $table->unsignedInteger('fitgapServiceWeight')->default(10);
            $table->unsignedInteger('fitgapOthersWeight')->default(10);

            $table->unsignedInteger('implementationImplementationWeight')->default(20);
            $table->unsignedInteger('implementationRunWeight')->default(80);
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
            $table->dropColumn('fitgapFunctionalWeight');
            $table->dropColumn('fitgapTechnicalWeight');
            $table->dropColumn('fitgapServiceWeight');
            $table->dropColumn('fitgapOthersWeight');
        });
    }
}
