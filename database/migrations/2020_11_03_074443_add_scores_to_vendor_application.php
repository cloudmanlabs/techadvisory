<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add scores fields to Vendor Application
 * The fields are:
 *  2 overall scores: overall & ranking scores
 *  5 fitgap scores: fitgap, functional, technical, service & others score
 *  1 vendor score
 *  1 experience score
 *  1 innovation score
 *  3 implementation score: implementation, implementation-implementation & implementation-run score
 * Class AddScoresToVendorApplication
 */
class AddScoresToVendorApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'overall_score')) {
                $table->double('overall_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'ranking_score')) {
                $table->double('ranking_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'fitgap_score')) {
                $table->double('fitgap_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'fitgap_functional_score')) {
                $table->double('fitgap_functional_score', 8, 2)->nullable();
            }
        });


        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'fitgap_technical_score')) {
                $table->double('fitgap_technical_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'fitgap_service_score')) {
                $table->double('fitgap_service_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'fitgap_others_score')) {
                $table->double('fitgap_others_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'vendor_score')) {
                $table->double('vendor_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'experience_score')) {
                $table->double('experience_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'innovation_score')) {
                $table->double('innovation_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'implementation_score')) {
                $table->double('implementation_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'implementation_implementation_score')) {
                $table->double('implementation_implementation_score', 8, 2)->nullable();
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_applications', 'implementation_run_score')) {
                $table->double('implementation_run_score', 8, 2)->nullable();
            }
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
            if (Schema::hasColumn('vendor_applications', 'overall_score')) {
                $table->dropColumn('overall_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'ranking_score')) {
                $table->dropColumn('ranking_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'fitgap_score')) {
                $table->dropColumn('fitgap_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'fitgap_functional_score')) {
                $table->dropColumn('fitgap_functional_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'fitgap_technical_score')) {
                $table->dropColumn('fitgap_technical_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'fitgap_service_score')) {
                $table->dropColumn('fitgap_service_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'fitgap_others_score')) {
                $table->dropColumn('fitgap_others_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'vendor_score')) {
                $table->dropColumn('vendor_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'experience_score')) {
                $table->dropColumn('experience_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'innovation_score')) {
                $table->dropColumn('innovation_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'implementation_score')) {
                $table->dropColumn('implementation_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'implementation_implementation_score')) {
                $table->dropColumn('implementation_implementation_score', 8, 2);
            }
        });

        Schema::table('vendor_applications', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_applications', 'implementation_run_score')) {
                $table->dropColumn('implementation_run_score', 8, 2);
            }
        });
    }
}
