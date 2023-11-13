<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePrestations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestations', function (Blueprint $table) {
            $table->id();
            $table->string('type_entreprise');
            $table->string('type_demande');
            $table->string('type')->nullable();
            $table->string('code');
            $table->string('libelle');
            $table->integer('montant');
            $table->string('description');
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
        Schema::dropIfExists('prestations');
    }
}
