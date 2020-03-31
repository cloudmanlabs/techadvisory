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

            $table->string('name');

            $table->boolean('hasOrals')->default(false);
            $table->boolean('hasValueTargeting')->default(false);

            $table->integer('progressSetUp')->default(0);
            $table->integer('progressValue')->default(0);
            $table->integer('progressResponse')->default(0);
            $table->integer('progressAnalytics')->default(0);
            $table->integer('progressConclusions')->default(0);

            $table->string('currentPhase')->default('preparation');

            $table->unsignedBigInteger('practice_id');
            $table->unsignedBigInteger('client_id');
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
