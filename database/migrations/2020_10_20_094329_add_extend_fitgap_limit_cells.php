<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Alter table for extend the limit from Fitgap files.
 * (From text to mediumtext
 * Class AddExtendFitgapLimitCells
 */
class AddExtendFitgapLimitCells extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Accenture Columns
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'fitgap5Columns')) {
                $table->mediumText('fitgap5Columns')->nullable()->change();
            } else {
                $table->mediumText('fitgap5Columns')->nullable();
            }
        });

        // Client Columns
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'fitgapClientColumns')) {
                $table->mediumText('fitgapClientColumns')->nullable()->change();
            } else {
                $table->mediumText('fitgapClientColumns')->nullable();
            }
        });

        // Vendor Columns
        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'fitgapVendorColumns')) {
                $table->mediumText('fitgapVendorColumns')->nullable()->change();
            } else {
                $table->mediumText('fitgapVendorColumns')->nullable();
            }
        });

        // Vendor Scores.
        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'fitgapVendorScores')) {
                $table->mediumText('fitgapVendorScores')->nullable()->change();
            } else {
                $table->mediumText('fitgapVendorScores')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     * Rollback to the previous state, fields limited to TEXT (64 kb).
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'fitgap5Columns')) {
                $table->text('fitgap5Columns')->nullable()->change();
            }
        });

        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'fitgapClientColumns')) {
                $table->text('fitgapClientColumns')->nullable()->change();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'fitgapVendorScores')) {
                $table->text('fitgapVendorScores')->nullable()->change();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'fitgap5Columns')) {
                $table->text('fitgap5Columns')->nullable()->change();
            }
        });
    }
}
