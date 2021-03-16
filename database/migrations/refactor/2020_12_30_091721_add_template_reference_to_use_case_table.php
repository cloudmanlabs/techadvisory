<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateReferenceToUseCaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_case', function (Blueprint $table) {
            $table->foreignId('template_id')->nullable(false);
            $table->foreign('template_id')
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
            $table->dropForeign(['template_id']);
        });
    }
}
