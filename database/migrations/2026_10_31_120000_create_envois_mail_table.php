<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Historique des e-mails envoyés par l'application (décision du CEFORE, code d'inscription, mot de passe oublié),
 * réussis ou en échec. Affiché dans la rubrique « Activité du promoteur » de la page de traitement (espace agents).
 */
class CreateEnvoisMailTable extends Migration
{
    public function up()
    {
        Schema::create('envois_mail', function (Blueprint $table) {
            $table->id();
            $table->string('type', 40);                 // validation, rejet, code_inscription, mot_de_passe
            $table->string('destinataire', 255)->nullable();
            $table->string('objet', 255)->nullable();   // sans donnée secrète (le code d'inscription n'y figure pas)
            $table->string('statut', 10);               // envoye, echec
            $table->string('erreur', 500)->nullable();
            $table->unsignedBigInteger('demande_id')->nullable();
            $table->unsignedBigInteger('declencheur_id')->nullable();   // compte connecté au moment de l'envoi (agent ou promoteur)
            $table->timestamps();
            $table->index('demande_id');
            $table->index(['destinataire', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('envois_mail');
    }
}
