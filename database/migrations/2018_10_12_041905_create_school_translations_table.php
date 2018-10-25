<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->unsigned();
            $table->string('name');
            $table->string('locality');
            $table->string('address');
            $table->string('near_by');
            $table->string('locale')->index();
            $table->timestamps();

            $table->unique(['school_id', 'locale']);
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_translations');
    }
}
