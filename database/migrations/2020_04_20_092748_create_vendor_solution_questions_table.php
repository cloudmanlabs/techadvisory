<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorSolutionQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_solution_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('label');
            $table->string('type');

            $table->string('placeholder')->nullable();
            $table->string('presetOption')->nullable();
            $table->text('options')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_solution_questions');
    }
}
