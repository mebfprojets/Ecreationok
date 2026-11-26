<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Date de copie de chaque ligne vers la base tampon locale (procédures Ligne_* exécutées depuis le serveur tampon,
 * à travers le serveur lié LIGNE). Vide = pas encore copiée ; la remettre à vide fait recopier la ligne au passage suivant.
 * L'index permet aux procédures de ne lire que les lignes en attente.
 */
class AddSynchroTamponLeAuxTablesEnLigne extends Migration
{
    private const TABLES = ['usagers', 'demandes', 'piece_jointes', 'demande_dirigeants'];

    public function up()
    {
        foreach (self::TABLES as $nom) {
            Schema::table($nom, function (Blueprint $table) use ($nom) {
                $table->dateTime('synchro_tampon_le')->nullable();
                $table->index('synchro_tampon_le', $nom.'_synchro_tampon_le_index');
            });
        }
    }

    public function down()
    {
        foreach (self::TABLES as $nom) {
            Schema::table($nom, function (Blueprint $table) use ($nom) {
                $table->dropIndex($nom.'_synchro_tampon_le_index');
                $table->dropColumn('synchro_tampon_le');
            });
        }
    }
}
