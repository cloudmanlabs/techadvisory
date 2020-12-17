<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_cases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('project_id')->nullable(false);
            $table->string('name')->nullable(false);
            $table->text('description')->nullable();
            $table->text('expected_results')->nullable();
            $table->foreignId('practice_id')->nullable(false);
            $table->string('transportFlow')->nullable(false);
            $table->string('transportMode')->nullable(false);
            $table->string('transportType')->nullable(false);

            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->onDelete('cascade');

            $table->foreign('practice_id')
                ->references('id')->on('practices');

            $table->string('accentureUsers');
            $table->string('clientUsers');
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
            $table->dropForeign(['project_id']);

        });

        Schema::dropIfExists('use_cases');
    }
}
