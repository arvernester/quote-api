<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodeAlternateFieldToCountriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('code_alternate', 2)
                ->nullable()
                ->after('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('code_alternate');
        });
    }
}
