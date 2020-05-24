<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendorFitgapFieldsToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedInteger('fitgapWeightFullySupports')->default(3);
            $table->unsignedInteger('fitgapWeightPartiallySupports')->default(2);
            $table->unsignedInteger('fitgapWeightPlanned')->default(1);
            $table->unsignedInteger('fitgapWeightNotSupported')->default(0);
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
            //
        });
    }
}
