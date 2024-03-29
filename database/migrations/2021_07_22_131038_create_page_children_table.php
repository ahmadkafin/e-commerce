<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_children', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fid_page')->unsigned();
            $table->foreign('fid_page')->references('id')->on('pages')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('page_name', 50)->unique();
            $table->string('route_name', 50)->unique();
            $table->string('title', 50)->nullable();
            $table->boolean('_isActive')->default(false);
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
        Schema::dropIfExists('page_children');
    }
}
