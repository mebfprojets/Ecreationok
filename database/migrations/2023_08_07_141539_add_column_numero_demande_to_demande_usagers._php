<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNumeroDemandeToDemandeUsagers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demande_usagers', function (Blueprint $table) {
            //
            $table->string("numero_demande")->nullable();
            $table->integer("paye")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande_usagers', function (Blueprint $table) {
            //
            $table->dropColumn('numero_demande');
            $table->dropColumn('paye');
        });
    }
}
