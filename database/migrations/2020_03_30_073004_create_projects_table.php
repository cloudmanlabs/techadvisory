<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name')->default('New project');

            $table->boolean('hasOrals')->default(false);
            $table->boolean('hasValueTargeting')->default(false);

            $table->string('currentPhase')->default('preparation');

            $table->dateTime('deadline')->nullable();
            $table->boolean('publishedAnalytics')->default(false);

            $table->unsignedBigInteger('practice_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();

            $table->boolean('isBinding')->default(false);
            $table->string('industry')->nullable();
            $table->string('projectType')->nullable();
            $table->text('regions')->nullable();

            $table->boolean('step3SubmittedAccenture')->default(false);
            $table->boolean('step3SubmittedClient')->default(false);
            $table->boolean('step4SubmittedAccenture')->default(false);
            $table->boolean('step4SubmittedClient')->default(false);

            $table->string('oralsLocation')->nullable();
            $table->dateTime('oralsFromDate')->nullable();
            $table->dateTime('oralsToDate')->nullable();

            $table->text('rfpOtherInfo')->nullable();

            $table->text('fitgap5Columns')->nullable();
            $table->text('fitgapClientColumns')->nullable();
            $table->unsignedInteger('fitgapWeightMust')->default(10);
            $table->unsignedInteger('fitgapWeightRequired')->default(5);
            $table->unsignedInteger('fitgapWeightNiceToHave')->default(1);

            $table->text('scoringValues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
