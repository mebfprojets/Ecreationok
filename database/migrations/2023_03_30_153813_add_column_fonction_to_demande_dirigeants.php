<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFonctionToDemandeDirigeants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demande_dirigeants', function (Blueprint $table) {
            //
            $table->integer('fonction_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande_dirigeants', function (Blueprint $table) {
            //
            $table->dropColumn('fonction_code');
        });
    }
}
