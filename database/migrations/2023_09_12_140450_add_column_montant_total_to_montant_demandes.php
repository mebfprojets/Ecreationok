<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnMontantTotalToMontantDemandes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('montant_demandes', function (Blueprint $table) {
            //
            $table->bigInteger("montant_total")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('montant_demandes', function (Blueprint $table) {
            //
            $table->dropColumn('montant_total');
        });
    }
}
