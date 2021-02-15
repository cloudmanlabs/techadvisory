<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUseCaseTemplateIdToUseCaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_case', function (Blueprint $table) {
            $table->foreignId('use_case_template_id')->nullable();
            $table->foreign('use_case_template_id')
                ->references('id')->on('use_case_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('use_case', function (Blueprint $table) {
            $table->dropForeign(['use_case_template_id']);
            $table->dropColumn('use_case_template_id');
        });
    }
}
