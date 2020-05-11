<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_applications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('vendor_id');

            $table->string('phase')->default('invitation');

            $table->boolean('invitedToOrals')->default(false);
            $table->boolean('oralsCompleted')->default(false);

            $table->integer('progressFitgap')->default(0);
            $table->integer('progressVendor')->default(0);
            $table->integer('progressExperience')->default(0);
            $table->integer('progressInnovation')->default(0);
            $table->integer('progressImplementation')->default(0);
            $table->integer('progressSubmit')->default(0);

            $table->text('fitgapData')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_applications');
    }
}
