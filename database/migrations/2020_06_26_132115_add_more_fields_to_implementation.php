<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsToImplementation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_applications', function (Blueprint $table) {
            $table->text('pricingModelResponse')->nullable();
            $table->text('detailedBreakdownResponse')->nullable();

            $table->string('pricingModelUpload')->nullable();
            $table->string('detailedBreakdownUpload')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_applications', function (Blueprint $table) {
            $table->dropColumn('pricingModelResponse');
            $table->dropColumn('detailedBreakdownResponse');
            $table->dropColumn('pricingModelUpload');
            $table->dropColumn('detailedBreakdownUpload');
        });
    }
}
