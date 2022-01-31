<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePathStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('path_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('equipment_id')->nullable();
            $table->string('step_type');
            $table->integer('workers_number');
            $table->float('worker_hour_pay');
            $table->integer('production_time_rate');
            $table->float('step_total_budget');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('path_steps');
    }
}
