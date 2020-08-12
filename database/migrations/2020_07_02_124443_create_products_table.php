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
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string('name');
            $table->string('image');
            $table->mediumText('description');
            $table->boolean('visibility')->default('1');
            $table->bigInteger('price');
            $table->bigInteger('stock');
            $table->string('sku')->nullable();
            $table->integer('weight');
            $table->integer('long');
            $table->integer('width');
            $table->integer('height');
            $table->string('video_url')->nullable();
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
        Schema::dropIfExists('products');
    }
}
