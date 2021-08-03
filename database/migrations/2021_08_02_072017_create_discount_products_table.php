<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('uid_disc')->unsigned();
            $table->foreign('uid_disc')->references('id')->on('discounts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('uid_products');
            $table->foreign('uid_products')->references('sku')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('disc_percent')->nullable();
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
        Schema::dropIfExists('discount_products');
    }
}
