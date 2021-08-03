<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('page_name', 50)->unique();
            $table->string('slugs', 50)->unique();
            $table->string('route_name', 50)->unique();
            $table->string('query', 50)->nullable();
            $table->string('page_view', 50);
            $table->string('middleware', 50)->nullable();
            $table->boolean('_haveChild')->default(false);
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
        Schema::dropIfExists('pages');
    }
}
