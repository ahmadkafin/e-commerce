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
            $table->bigIncrements('id');
            $table->string('sku', 20)->unique();
            $table->string('slugs', 50)->nullable();
            $table->string('nama', 40);
            $table->string('warna', 10);
            $table->integer('total');
            $table->double('harga', 10,2);
            $table->longText('deskripsi')->comment("HTML TAG WYSIWYG")->nullable();
            $table->boolean('_isDiscount')->default(false);
            $table->softDeletes();
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
