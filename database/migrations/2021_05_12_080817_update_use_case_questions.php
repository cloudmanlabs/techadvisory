<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUseCaseQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_case_questions', function (Blueprint $table) {
            $table->foreignId('practice_id')->nullable()->change();
        });
    }
}
