<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Notifications du promoteur : date à laquelle il a vu une action d'agent sur son dossier (en ouvrant le dossier).
 * Les actions déjà enregistrées sont considérées comme vues, pour ne pas notifier tout l'historique.
 */
class AddVuPromoteurLeToJournalActions extends Migration
{
    public function up()
    {
        Schema::table('journal_actions', function (Blueprint $table) {
            $table->dateTime('vu_promoteur_le')->nullable();
            $table->index(['demande_id', 'vu_promoteur_le'], 'journal_actions_demande_vu_index');
        });
        DB::table('journal_actions')->update(['vu_promoteur_le' => DB::raw('created_at')]);
    }

    public function down()
    {
        Schema::table('journal_actions', function (Blueprint $table) {
            $table->dropIndex('journal_actions_demande_vu_index');
            $table->dropColumn('vu_promoteur_le');
        });
    }
}
