<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteCascadeToTemplateIdInUseCaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_case', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->foreign('template_id')
                ->references('id')->on('use_case_templates')
                ->onDelete('cascade')->change();
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
            $table->foreign('template_id')->references('id')->on('use_case_templates')->change();
        });
    }
}
