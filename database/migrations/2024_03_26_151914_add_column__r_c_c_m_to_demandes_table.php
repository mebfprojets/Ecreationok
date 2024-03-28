<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRCCMToDemandesTable extends Migration
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
            $table->string("RCCM")->nullable();
            $table->date("DateRCCM")->nullable();
            $table->string("IFU")->nullable();
            $table->date("DateIFU")->nullable();
            $table->string("CNSS")->nullable();
            $table->date("DateCNSS")->nullable();
            $table->string("CPC")->nullable();
            $table->date("DateCPC")->nullable();

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
        });
    }
}
