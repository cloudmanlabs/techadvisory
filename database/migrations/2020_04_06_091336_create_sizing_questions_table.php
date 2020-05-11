<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizingQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizing_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('label');
            $table->string('type');

            $table->string('placeholder')->nullable();
            $table->boolean('required')->default(false);
            $table->string('presetOption')->nullable();
            $table->text('options')->nullable();

            $table->unsignedBigInteger('practice_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sizing_questions');
    }
}
