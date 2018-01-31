<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuoteTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('quote_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id')->unsigned();
            $table->integer('source_lang_id')->unsigned();
            $table->integer('destination_lang_id')->unsigned();
            $table->text('text');
            $table->timestamps();

            $table->foreign('quote_id')
                ->references('id')
                ->on('quotes');

            $table->foreign('source_lang_id')
                ->references('id')
                ->on('languages');

            $table->foreign('destination_lang_id')
                ->references('id')
                ->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('quote_translations');
    }
}
