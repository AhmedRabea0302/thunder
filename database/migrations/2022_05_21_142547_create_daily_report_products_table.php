<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyReportProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_report_products', function (Blueprint $table) {
            $table->id();
            $table->integer('daily_report_id');
            $table->bigInteger('product_id');
            $table->double('quantity');
            $table->double('corrupted_quantity');
            $table->string('corrupted_unit');
            $table->double('unit_value');
            $table->double('total');
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
        Schema::dropIfExists('daily_report_products');
    }
}
