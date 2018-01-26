<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuoteTweetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('quote_tweets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id')
                ->unsigned();
            $table->timestamps();

            $table->foreign('quote_id')
                ->references('id')
                ->on('quotes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('quote_tweets');
    }
}
