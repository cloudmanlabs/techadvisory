<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFitgapLevelWeightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fitgap_level_weights', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('project_id')->nullable(false);
            $table->foreign('project_id')
                ->references('id')->on('projects');

            $table->string('name')->nullable(false);
            $table->unsignedInteger('weight')->nullable(false)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fitgap_level_weights');
    }
}
