<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fid_prod', 20);
            $table->foreign('fid_prod')->references('sku')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->bigInteger('fid_col')->unsigned();
            $table->foreign('fid_col')->references('id')->on('collections')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('product_collections');
    }
}
