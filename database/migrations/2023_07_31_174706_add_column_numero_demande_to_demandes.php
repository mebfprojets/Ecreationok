<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNumeroDemandeToDemandes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demandes', function (Blueprint $table) {
            //
            $table->string("numero_demande")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demandes', function (Blueprint $table) {
            //
            $table->dropColumn('numero_demande');
        });
    }
}
