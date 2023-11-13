<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUrlLigneToPieceJointes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('piece_jointes', function (Blueprint $table) {
            //
            $table->string("url_local")->nullable();
            $table->string("id_ligne")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('piece_jointes', function (Blueprint $table) {
            //
            $table->dropColumn('url_local');
            $table->dropColumn('id_ligne');

        });
    }
}
