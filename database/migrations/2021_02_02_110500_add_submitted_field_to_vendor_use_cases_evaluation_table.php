<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubmittedFieldToVendorUseCasesEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_use_cases_evaluation', function (Blueprint $table) {
            $table->string('submitted')->nullable(false)->default('no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_use_cases_evaluation', function (Blueprint $table) {
            $table->dropColumn('submitted');
        });
    }
}
