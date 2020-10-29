<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFitgapBackup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_applications', function (Blueprint $table) {
            $table->longText('fitgapVendorColumnsOld')->nullable();
            $table->longText('fitgapVendorColumnsOld2')->nullable();
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
            $table->dropColumn('fitgapVendorColumnsOld');
            $table->dropColumn('fitgapVendorColumnsOld2');
        });
    }
}
