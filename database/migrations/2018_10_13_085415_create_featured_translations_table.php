<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturedTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('featured_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();
            $table->timestamps();

            $table->unique(['featured_id', 'locale']);
            $table->foreign('featured_id')->references('id')->on('featureds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('featured_translations');
    }
}
