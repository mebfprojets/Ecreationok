<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeForMoovToPaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paiements', function (Blueprint $table) {
            //
            $table->integer("type")->nullable();
            $table->string("requestId")->nullable();
            $table->string("echec_moov")->nullable();
            $table->string("numero_tel")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paiements', function (Blueprint $table) {
            //
            $table->dropColumn('type');
            $table->dropColumn('requestId');
            $table->dropColumn('echec_moov');
            $table->dropColumn('numero_tel');

        });
    }
}
