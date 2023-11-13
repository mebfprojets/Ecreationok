<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRegimeMatrimonialToUsagerConjoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usager_conjoints', function (Blueprint $table) {
            //
            $table->integer("regime_matrimonial")->nullable();
            $table->string("lieu_mariage")->nullable();
            $table->date("date_mariage")->nullable();
            //$table->string("id_ligne")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usager_conjoints', function (Blueprint $table) {
            //
            $table->dropColumn('regime_matrimonial');
            $table->dropColumn('lieu_mariage');
            $table->dropColumn('date_mariage');
        });
    }
}
