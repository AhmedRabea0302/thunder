<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tree_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_tree_id');
            $table->unsignedBigInteger('product_id');
            $table->float('quantity');
            $table->float('wasted_quantity');
            $table->float('total_quantity');

            $table->foreign('product_tree_id')->references('id')->on('product_trees')->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('tree_products');
    }
}
