<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseCaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_case', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name')->nullable(false);
            $table->text('description')->nullable(false);

            $table->foreignId('practice_id')->nullable(false);
            $table->foreign('practice_id')
                ->references('id')->on('practices');

            $table->foreignId('project_id')->nullable(false);
            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->onDelete('cascade');

            $table->string('accentureUsers');
            $table->string('clientUsers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('use_case');
    }
}
