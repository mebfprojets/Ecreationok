<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Index sur les colonnes de liaison utilisées par les listes et la page de traitement
 * (promoteur -> demandes, compte -> promoteur, demande -> pièces / historique).
 * Chaque index n'est créé que s'il n'existe pas déjà : certaines bases ont reçu des index ajoutés à la main.
 */
class AddIndexColonnesLiaison extends Migration
{
    private const INDEX = [
        ['demandes', 'usager_id', 'demandes_usager_id_index'],
        ['usagers', 'user_id', 'usagers_user_id_index'],
        ['piece_jointes', 'demande_id', 'piece_jointes_demande_id_index'],
        ['piece_jointes', 'usager_id', 'piece_jointes_usager_id_index'],
        ['historiques', 'id_demande', 'historiques_id_demande_index'],
    ];

    public function up()
    {
        foreach (self::INDEX as [$table, $colonne, $nom]) {
            if (!$this->existe($table, $colonne)) {
                Schema::table($table, fn (Blueprint $t) => $t->index($colonne, $nom));
            }
        }
    }

    public function down()
    {
        foreach (self::INDEX as [$table, , $nom]) {
            if (DB::selectOne('SELECT 1 AS ok FROM sys.indexes WHERE name = ? AND object_id = OBJECT_ID(?)', [$nom, $table])) {
                Schema::table($table, fn (Blueprint $t) => $t->dropIndex($nom));
            }
        }
    }

    /** Un index dont la première colonne est $colonne existe-t-il déjà (quel que soit son nom) ? */
    private function existe(string $table, string $colonne): bool
    {
        return (bool) DB::selectOne(
            'SELECT 1 AS ok FROM sys.indexes i
             JOIN sys.index_columns ic ON ic.object_id = i.object_id AND ic.index_id = i.index_id AND ic.key_ordinal = 1
             JOIN sys.columns c ON c.object_id = ic.object_id AND c.column_id = ic.column_id
             WHERE i.object_id = OBJECT_ID(?) AND c.name = ?',
            [$table, $colonne]
        );
    }
}
