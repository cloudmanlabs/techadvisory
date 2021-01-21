<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyFieldsFromVendorUseCasesEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_use_cases_evaluation', function (Blueprint $table) {
            $table->text('comments')->nullable(true);
            $table->dropForeign('vendor_use_cases_evaluation_client_id_foreign');
            $table->string('evaluation_type')->nullable(false)->default('client');
        });

        Schema::table('vendor_use_cases_evaluation', function (Blueprint $table) {
            //$table->bigInteger('client_id')->change();
            $table->renameColumn('client_id', 'user_credential');
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
            $table->renameColumn('user_credential', 'client_id');
            $table->dropColumn('comments');
            $table->dropColumn('evaluation_type');
        });

        Schema::table('vendor_use_cases_evaluation', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable(false)->change();
            $table->foreign('client_id')
                ->references('id')->on('user_credentials');
        });
    }
}
