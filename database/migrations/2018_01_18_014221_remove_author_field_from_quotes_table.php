<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAuthorFieldFromQuotesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('author');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->string('author', 100)
                ->nullable()
                ->after('text');
        });
    }
}
