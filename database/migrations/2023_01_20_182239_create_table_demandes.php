<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDemandes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->string('request_type');//Type Demande
            $table->string('company_type'); // Type Entreprise
           // $table->date('request_date');
           $table->string('created_by')->nullable();
           $table->string('modified_by')->nullable();
           $table->integer('acting')->default(0); // Champs agissant au compte de
           $table->string('usager_id'); // id Usager
           $table->string('legal_representative')->nullable(); // Id Usager dans Nav
           $table->string('legal_rep_name')->nullable(); // Nom usager dans NAV
           $table->string('origin_request_code')->nullable(); //Origine de la demande (Création)
           $table->string('serial_no')->nullable(); // Numéro de serie dans NAV
           $table->integer('type_entreprise'); // 0 pour Physique et 1 pour Morale dans NAV
           $table->integer('amount_timbre'); // montant sticker , 500 F si y a demande CPC sinon 0 F
           $table->integer('nature_demande'); // 1 pour création 
           //$table->bigInteger('seuil_min_capital')->nullable(); // A chercher a comprendre
           $table->bigInteger('nbre_actions')->nullable();
           $table->bigInteger('capital_en_numeraire')->nullable();
           $table->bigInteger('capital_en_industrie')->nullable(); 
           $table->bigInteger('capital_social')->nullable(); // Montant Total
           $table->integer('vie_societe_duree')->nullable(); // 99ans pour morale et null pour physique
           $table->bigInteger('montant_action')->nullable(); // Valeur nomminale 
           $table->bigInteger('seuil_min_capital')->nullable();
           $table->integer('id_terrain'); // Une autre table Terrain a crerr
           $table->integer('statut'); // Statut de la demande
           $table->string('institution_type'); // Table a créer 
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
           $table->integer('region_code');
           $table->integer('province_code');
           $table->integer('commune_departement_code');
           $table->integer('arrondissement_code');
           $table->string('code_secteur_village');
           $table->string('avenue')->nullable();
           $table->string('boite_postale');
           $table->string('rue')->nullable();
           $table->string('pays')->nullable(); // Par defaut BF
           $table->integer('mobile_1');
           $table->string('tel_bureau')->nullable();
           $table->string('adress')->nullable(); // Champ Boite Postale dans NAV
           $table->string('quartier');
           $table->integer('porte');
           $table->string('email');
           $table->integer('home_page')->nullable();
           $table->integer('mobile_2')->nullable();
           $table->string('type_adresse'); // Adresse identique à celle du promoteur 0 (Nouveau) et 1(Identique)
           $table->integer('confirm_request'); // 0 ou 1 pour dire demande confirmée
           $table->string('division_fiscale_code');
           $table->string('code_direction_impot');
           $table->string('organisation_code');
           $table->string('forme_juridique');
           $table->string('signature_demandeur');
           $table->string('entreprise_no')->nullable(); // Id Entreprise
           $table->string('activity_category_code'); //
           $table->string('objet_social');
           
           
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
        Schema::dropIfExists('table_demandes');
    }
}
