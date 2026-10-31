<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Activité des comptes : connexions (réussies, échouées, déconnexions) et modifications faites par le promoteur
 * sur son dossier. Le reste du parcours (création du compte, pièces, demande, paiements, renvois) est déjà
 * retrouvé dans les tables existantes.
 */
class CreateActivitesPromoteurTable extends Migration
{
    public function up()
    {
        Schema::create('activites_promoteur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('demande_id')->nullable();
            $table->string('action', 40);      // connexion, connexion_echouee, deconnexion, demande_modifiee, dirigeant_modifie, piece_remplacee
            $table->text('detail')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('navigateur', 255)->nullable();
            $table->timestamps();
            $table->index(['user_id', 'created_at']);
            $table->index('demande_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activites_promoteur');
    }
}
