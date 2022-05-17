<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePathExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('path_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('path_id');
            $table->unsignedBigInteger('equipment_id');
            $table->string('expense_type');
            $table->float('expense_value');

            $table->foreign('path_id')->references('id')->on('paths')->onDelete('cascade');

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
        Schema::dropIfExists('path_expenses');
    }
}
