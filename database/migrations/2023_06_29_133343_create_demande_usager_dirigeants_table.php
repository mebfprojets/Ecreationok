<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeUsagerDirigeantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demande_usager_dirigeants', function (Blueprint $table) {
            $table->id();
            $table->integer('demande_id');
            $table->integer('usager_id'); // Champs agissant au compte de
            $table->integer("Type");
            $table->string("NomRaisonSociale");
            $table->string("Prenom")->nullable(); 
            $table->string("IdFonction")->nullable();
            $table->date("DateNaissance")->nullable();
            $table->string("LieuNaissance")->nullable();
            $table->integer("Gender")->nullable();
            $table->integer("SituationMatrimoniale")->nullable();
            $table->string("IdPere")->nullable();
            $table->string("IdMere")->nullable();
            $table->string("NumeroCNSS")->nullable();
            $table->date("DateEtablissementCNSS")->nullable();
            $table->string("NumeroRCCM")->nullable();
            $table->date("DateEtablissementRCCM")->nullable();
            $table->string("IdCategorieUsager");
            $table->string("NumeroIFU")->nullable();
            $table->date("DateEtablissementIFU")->nullable();
            $table->string("IdAdresse")->nullable(); // Correspond au champ de saisie adresse, sans liée à une table
            $table->string("Signature")->nullable(); //Correspond à l'image de la signature dans la table Usager de NAV
            $table->string("Country_Code");// Code Pays
            $table->integer("Civility"); //Parametre Valeur
            $table->string("CIN")->nullable(); //Corespond à numéro d'identification (CNIB ou Passport)
            $table->string("FormeJuridique")->nullable();
            $table->string("Region_Code")->nullable(); // En cas de hors-Burkina, mettres les valeurs à nullable
            $table->string("Province_Code")->nullable();
            $table->string("Commun_Departement_Code")->nullable();
            $table->string("Arrondissement_Code")->nullable();
            $table->string("Code_Secteur_Village")->nullable();
            $table->string("Boite_postale")->nullable();
            $table->string("Tel_Bureau")->nullable();
            $table->string("Organisation_Code")->nullable(); //Code CEFORE qui doit traiter le document
            $table->string("Phone_No_")->nullable();
            $table->string("E-Mail")->nullable();
            $table->string("Nationality_No_");

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
        Schema::dropIfExists('demande_usager_dirigeant');
    }
}
