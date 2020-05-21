<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_applications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('vendor_id');

            $table->string('phase')->default('invitation');

            $table->boolean('invitedToOrals')->default(false);
            $table->boolean('oralsCompleted')->default(false);

            $table->text('fitgapVendorColumns')->nullable();
            $table->text('fitgapVendorScores')->nullable();

            $table->text('deliverables')->nullable();
            $table->text('raciMatrix')->nullable();
            $table->text('staffingCost')->nullable();
            $table->text('travelCost')->nullable();
            $table->text('additionalCost')->nullable();
            $table->text('estimate5Years')->nullable();
            $table->unsignedInteger('estimate5YearsYear0')->nullable();

            $table->unsignedInteger('overallImplementationMin')->nullable();
            $table->unsignedInteger('overallImplementationMax')->nullable();
            $table->unsignedInteger('averageYearlyCostMin')->nullable();
            $table->unsignedInteger('averageYearlyCostMax')->nullable();
            $table->unsignedInteger('totalRunCostMin')->nullable();
            $table->unsignedInteger('totalRunCostMax')->nullable();

            $table->unsignedInteger('additionalCostScore')->nullable();
            $table->unsignedInteger('deliverablesScore')->nullable();
            $table->unsignedInteger('estimate5YearsScore')->nullable();
            $table->unsignedInteger('nonBindingEstimate5YearsScore')->nullable();
            $table->unsignedInteger('overallCostScore')->nullable();
            $table->unsignedInteger('raciMatrixScore')->nullable();
            $table->unsignedInteger('staffingCostScore')->nullable();
            $table->unsignedInteger('travelCostScore')->nullable();

            $table->unsignedInteger('staffingCostNonBinding')->nullable();
            $table->text('staffingCostNonBindingComments')->nullable();
            $table->unsignedInteger('travelCostNonBinding')->nullable();
            $table->text('travelCostNonBindingComments')->nullable();
            $table->unsignedInteger('additionalCostNonBinding')->nullable();
            $table->text('additionalCostNonBindingComments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_applications');
    }
}
