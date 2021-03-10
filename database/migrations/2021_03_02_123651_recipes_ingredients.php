<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecipesIngredients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes_ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('ingredients_id');
            $table->unsignedBigInteger('recipes_id');
            $table->string('quantity');
            $table->primary(['ingredients_id', 'recipes_id']);
            $table->foreign('ingredients_id')->references('id')->on('ingredients');
            $table->foreign('recipes_id')->references('id')->on('recipes');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes_ingredients');
    }
}