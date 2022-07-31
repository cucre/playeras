<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product');
            $table->text('description');
            $table->integer('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->integer('color_id');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->integer('talla_id');
            $table->foreign('talla_id')->references('id')->on('tallas');
            $table->string('gender');
            $table->binary('photo');
            $table->double('purchase_price', 8, 2);
            $table->double('selling_price', 8, 2);
            $table->double('customer_price', 8, 2);
            $table->integer('created_by')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }
}
