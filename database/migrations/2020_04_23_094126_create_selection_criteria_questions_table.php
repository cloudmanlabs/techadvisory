<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectionCriteriaQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selection_criteria_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('label');
            $table->string('type');

            $table->string('placeholder')->nullable();
            $table->boolean('required')->default(false);
            $table->string('presetOption')->nullable();
            $table->string('options')->nullable();

            $table->string('page')->default('vendor_corporate');

            $table->boolean('fixed')->default(false);
            $table->string('fixedQuestionIdentifier')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('selection_criteria_questions');
    }
}
