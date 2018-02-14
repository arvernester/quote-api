<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('author_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')
                ->unsigned();
            $table->integer('language_id')
                ->unsigned();
            $table->text('about');
            $table->string('url')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')
                ->on('authors');

            $table->foreign('language_id')
                ->references('id')
                ->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('author_profiles');
    }
}
