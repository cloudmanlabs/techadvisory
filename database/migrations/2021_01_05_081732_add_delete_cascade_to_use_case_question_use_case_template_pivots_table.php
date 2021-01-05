<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteCascadeToUseCaseQuestionUseCaseTemplatePivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_case_question_use_case_template_pivots', function (Blueprint $table) {
            $table->dropForeign('uct_id');
            $table->foreign('use_case_templates_id', 'uct_id')
                ->references('id')->on('use_case_templates')
                ->onDelete('cascade')->change();

//            $table->dropForeign(['template_id']);
//            $table->foreign('template_id')
//                ->references('id')->on('use_case_templates')
//                ->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('use_case_question_use_case_template_pivots', function (Blueprint $table) {
            $table->foreign('use_case_templates_id', 'uct_id')->references('id')->on('use_case_templates')->change();
//            $table->foreign('template_id')->references('id')->on('use_case_templates')->change();
        });
    }
}
