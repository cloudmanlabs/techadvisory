<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreBackups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_applications', function (Blueprint $table) {
            $table->longText('fitgapVendorColumnsOld3')->nullable();
            $table->longText('fitgapVendorColumnsOld4')->nullable();
            $table->longText('fitgapVendorColumnsOld5')->nullable();
            $table->longText('fitgapVendorColumnsOld6')->nullable();
            $table->longText('fitgapVendorColumnsOld7')->nullable();
            $table->longText('fitgapVendorColumnsOld8')->nullable();
            $table->longText('fitgapVendorColumnsOld9')->nullable();
            $table->longText('fitgapVendorColumnsOld10')->nullable();
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
            $table->dropColumn('fitgapVendorColumnsOld3');
            $table->dropColumn('fitgapVendorColumnsOld4');
            $table->dropColumn('fitgapVendorColumnsOld5');
            $table->dropColumn('fitgapVendorColumnsOld6');
            $table->dropColumn('fitgapVendorColumnsOld7');
            $table->dropColumn('fitgapVendorColumnsOld8');
            $table->dropColumn('fitgapVendorColumnsOld9');
            $table->dropColumn('fitgapVendorColumnsOld10');
        });
    }
}
