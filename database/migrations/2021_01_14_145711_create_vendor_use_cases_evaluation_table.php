<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorUseCasesEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_use_cases_evaluation', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('use_case_id')->nullable(false);
            $table->foreign('use_case_id')
                ->references('id')->on('use_case');

            $table->foreignId('client_id')->nullable(false);
            $table->foreign('client_id')
                ->references('id')->on('user_credentials');

            $table->foreignId('vendor_id')->nullable(false);
            $table->foreign('vendor_id')
                ->references('id')->on('users');

            $table->decimal('solution_fit', 5)->nullable()->default(null);
            $table->decimal('usability', 5)->nullable()->default(null);
            $table->decimal('performance', 5)->nullable()->default(null);
            $table->decimal('look_feel', 5)->nullable()->default(null);
            $table->decimal('others', 5)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_use_cases_evaluation');
    }
}
