<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeDirigeantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demande_dirigeants', function (Blueprint $table) {
            $table->id();
            $table->integer('demande_id');
            $table->integer('type')->nullabe();
            $table->integer('usager_id');
            $table->integer('pourcentage_capital')->nullabe();
            $table->integer('personne_pouvant_engager')->nullabe();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demande_dirigeants');
    }
}
