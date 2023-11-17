<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeUsagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demande_usagers', function (Blueprint $table) {
            $table->id();
           $table->integer('demande_id'); // Champs agissant au compte de
           $table->integer('usager_id'); 
           $table->string('request_type');//Type Demande
            $table->string('company_type'); // Type Entreprise
           // $table->date('request_date');
           $table->integer('acting')->default(0); // Champs agissant au compte de
           $table->string('legal_representative')->nullable(); // Id Usager dans Nav
           $table->string('legal_rep_name')->nullable(); // Nom usager dans NAV
           //$table->string('origin_request_code')->nullable(); //Origine de la demande (Création)
           //$table->string('serial_no')->nullable(); // Numéro de serie dans NAV
           $table->integer('type_entreprise'); // 0 pour Physique et 1 pour Morale dans NAV
           $table->integer('amount_timbre'); // montant sticker , 500 F si y a demande CPC sinon 0 F
           $table->integer('nature_demande'); // 1 pour création 
           $table->bigInteger('seuil_min_capital')->nullable(); // A chercher a comprendre
           $table->bigInteger('nbre_actions')->nullable();
           $table->bigInteger('capital_en_nature')->nullable(); 
           $table->bigInteger('capital_en_numeraire')->nullable();
           $table->bigInteger('capital_en_industrie')->nullable(); 
           $table->bigInteger('capital_social')->nullable(); // Montant Total
           $table->integer('vie_societe_duree')->nullable(); // 99ans pour morale et null pour physique
           $table->bigInteger('montant_action')->nullable(); // Valeur nomminale
           $table->string('section')->nullable();
           $table->string('lot')->nullable();
           $table->string('parcelle')->nullable();
           $table->string('usage_terrain')->nullable();
           $table->integer('statut_demande'); // Statut de la demande
           $table->string('institution_type')->nullable(); // Table a créer 
           $table->bigInteger('chiffre_daffaire_previsionel'); // Champ Sales Forecasting Case dans NAV
           $table->string('taxation_regime'); // CME par defaut 
           $table->string('activity_sector'); // 
           $table->integer('employee_permanant')->nullable(); 
           $table->integer('employee_temporary')->nullable(); 
           $table->integer('employee_etranger')->nullable();
           $table->string('enseigne')->nullable();
           $table->string('commercial_name');
           $table->string('sigle')->nullable();
           $table->string('primary_activity');
           $table->date('begin_activity_date'); // Date de la demande
           $table->string('denomination_social');
           $table->string('region_entreprise');
           $table->string('province_entreprise');
           $table->string('commune_entreprise');
           $table->string('arrondissement_entreprise');
           $table->string('secteur_entreprise');
           $table->string('avenue_entreprise')->nullable();
           $table->string('boite_postale_entreprise');
           $table->string('rue_entreprise')->nullable();
           $table->string('pays_entreprise')->nullable(); // Par defaut BF
           $table->string('mobile_1_entreprise');
           $table->string('tel_bureau_entreprise')->nullable();
           $table->string('adress_entreprise')->nullable(); // Champ Boite Postale dans NAV
           $table->string('quartier_entreprise')->nullable();
           $table->string('porte_entreprise')->nullable();
           $table->string('email_entreprise')->nullable();
           $table->string('home_page')->nullable();
           $table->string('mobile_2_entreprise')->nullable();
           //$table->string('type_adresse_entreprise'); // Adresse identique à celle du promoteur 0 (Nouveau) et 1(Identique)
          // $table->integer('confirm_request'); // 0 ou 1 pour dire demande confirmée
           $table->string('division_fiscale_code')->nullable();
           $table->string('code_direction_impot')->nullable();
           $table->string('organisation_entreprise');
           $table->string('forme_juridique');
           $table->string('signature_demandeur');
           $table->string('activity_category_code')->nullable(); //
           $table->string('objet_social');
           $table->Integer('etat')->nullable();
           $table->Integer('avecCPC')->nullable();
           $table->Integer('montant')->nullable();
           $table->date('DateCreationDemande')->nullable();
           $table->date('DateCreationUsager')->nullable(); 



           // Tables Usager

           $table->integer("Type_usager");
            $table->string("NomRaisonSociale");
            $table->string("Prenom")->nullable(); 
            $table->string("FonctionUusager")->nullable();
            $table->date("DateNaissance")->nullable();
            $table->string("LieuNaissance")->nullable();
            $table->integer("Gender")->nullable();
            $table->integer("SituationMatrimoniale")->nullable();
            $table->string("IdCategorieUsager");
            $table->string("IdAdresse"); // Correspond au champ de saisie adresse, sans liée à une table
            $table->string("Signature")->nullable(); //Correspond à l'image de la signature dans la table Usager de NAV
            $table->string("CountryCode");// Code Pays
            $table->integer("Civility"); //Parametre Valeur
            $table->string("Cin")->nullable(); //Corespond à numéro d'identification (CNIB ou Passport)
            $table->string("FormeJuridique")->nullable();
            $table->string("RegionUsager")->nullable(); // En cas de hors-Burkina, mettres les valeurs à nullable
            $table->string("ProvinceUsager")->nullable();
            $table->string("CommunUsager")->nullable();
            $table->string("ArrondissementUsager")->nullable();
            $table->string("SecteurUsager")->nullable();
            $table->string("BoitePostaleUsager")->nullable();
            $table->string("TelBureauUsager")->nullable();
            $table->string("OrganisationCodeUsager")->nullable(); //Code CEFORE qui doit traiter le document
            $table->string("PhoneNo")->nullable();
            $table->string("MailUsager")->nullable();
            $table->string("NationalityNoUsager");
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
        Schema::dropIfExists('demande_usagers');
    }
}
