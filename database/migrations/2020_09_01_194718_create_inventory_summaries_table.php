<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventorySummariesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_summaries', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('stock')->default(0);
            $table->integer('created_by')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('inventory_summaries');
    }
}