<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDatemodificationToDemandeUsagers extends Migration
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
            $table->datetime("DateModificationDemande")->nullable();
            $table->datetime("DateModificationUsager")->nullable();

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
            $table->dropColumn('DateModificationDemande');
            $table->dropColumn('DateModificationUsager');

        });
    }
}
