<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnReferencePieceToPieceJoites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('piece_jointes', function (Blueprint $table) {
            $table->string('numero')->nullable();
            $table->date('date_etablissement')->nullable();
            $table->string('lieu_etablissement')->nullable();
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
            $table->dropColumn('numero');
            $table->dropColumn('date_etablissement');
            $table->dropColumn('lieu_etablissement');
            

        });
    }
}
