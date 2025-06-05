<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOrangeToPaiementsTable extends Migration
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
            $table->string("transId")->nullable();
            $table->string("message")->nullable();
            $table->string("echec_orange")->nullable();
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
            $table->dropColumn('transId');
            $table->dropColumn('message');
            $table->dropColumn('echec_orange');
        });
    }
}
