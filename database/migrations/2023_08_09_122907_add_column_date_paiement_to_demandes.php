<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDatePaiementToDemandes extends Migration
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
            $table->datetime("date_paiement")->nullable();
            $table->string("motif")->nullable();
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
            $table->dropColumn('date_paiement');
            $table->dropColumn('motif');

        });
    }
}
