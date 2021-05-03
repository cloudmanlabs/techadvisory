<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorSolutionSubpracticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subpractice_vendor_solution', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('vendor_solution_id');
            $table->unsignedBigInteger('subpractice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_solution_subpractice');
    }
}
