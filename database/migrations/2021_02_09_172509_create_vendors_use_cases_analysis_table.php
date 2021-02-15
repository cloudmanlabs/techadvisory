<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsUseCasesAnalysisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors_use_cases_analysis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('use_case_id')->nullable(false);
            $table->foreign('use_case_id')
                ->references('id')->on('use_case');

            $table->foreignId('vendor_id')->nullable(false);
            $table->foreign('vendor_id')
                ->references('id')->on('users');

            $table->foreignId('project_id')->nullable(false);
            $table->foreign('project_id')
                ->references('id')->on('projects');

            $table->decimal('solution_fit', 5)->nullable()->default(null);
            $table->decimal('usability', 5)->nullable()->default(null);
            $table->decimal('performance', 5)->nullable()->default(null);
            $table->decimal('look_feel', 5)->nullable()->default(null);
            $table->decimal('others', 5)->nullable()->default(null);
            $table->decimal('total', 5)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors_use_cases_analysis');
    }
}
