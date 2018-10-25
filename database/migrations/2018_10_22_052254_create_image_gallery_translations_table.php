<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageGalleryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_gallery_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_gallery_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();
            $table->timestamps();

            $table->unique(['image_gallery_id', 'locale']);
            $table->foreign('image_gallery_id')->references('id')->on('image_galleries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_gallery_translations');
    }
}
