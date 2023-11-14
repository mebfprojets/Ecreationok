<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDateDemandeToDemandeUsagersTable extends Migration
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
           $table->date('DateCreationDemande')->nullable(); // Champs agissant au compte de
           $table->date('DateCreationUsager')->nullable(); // Champs agissant au compte de

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
            $table->dropColumn('DateCreationDemande');
            $table->dropColumn('DateCreationUsager');

        });
    }
}
