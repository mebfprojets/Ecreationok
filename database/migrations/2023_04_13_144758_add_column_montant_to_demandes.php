<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnMontantToDemandes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->bigInteger('montant')->nullable();
            $table->integer('avecCPC')->nullable(); //Pour savoir si la demande est faite avec une demande de CPC
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
            $table->dropColumn('montant');
            $table->dropColumn('avecCPC');
        });
    }
}
