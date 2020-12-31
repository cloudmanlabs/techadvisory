<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseCaseQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_case_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('label')->nullable(false);
            $table->string('type')->nullable(false);
            $table->boolean('required')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('use_case_questions');
    }
}
