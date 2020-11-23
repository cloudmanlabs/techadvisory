<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFitgapToLongInVendorApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_applications', function (Blueprint $table) {
            $table->longText('fitgapVendorColumns')->change();
            $table->longText('fitgapVendorScores')->change();
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
            $table->text('fitgapVendorColumns')->change();
            $table->text('fitgapVendorScores')->change();
        });
    }
}
