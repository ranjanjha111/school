<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutritionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutrition_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nutrition_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();
            $table->timestamps();

            $table->unique(['nutrition_id', 'locale']);
            $table->foreign('nutrition_id')->references('id')->on('nutrition')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nutrition_translations');
    }
}
