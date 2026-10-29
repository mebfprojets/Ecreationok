<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Journal des actions des agents sur les demandes (validation, rejet, pièce modifiée, correction...).
 * Affiché sur le tableau de bord. Il est pré-rempli avec l'historique déjà présent en base :
 * validations (demandes.User_ayant_valide / Date_etat_validation) et rejets saisis par des agents (historiques).
 */
class CreateJournalActionsTable extends Migration
{
    public function up()
    {
        Schema::create('journal_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();     // agent
            $table->string('organisation')->nullable();             // CEFORE de l'agent au moment de l'action
            $table->string('action', 40);                           // validation, rejet, piece_modifiee, demande_corrigee, dirigeant_corrige
            $table->unsignedBigInteger('demande_id')->nullable();
            $table->text('detail')->nullable();                     // motif du rejet, pièce concernée...
            $table->timestamps();
            $table->index('created_at');
            $table->index('demande_id');
        });

        DB::table('journal_actions')->insertUsing(
            ['user_id', 'organisation', 'action', 'demande_id', 'detail', 'created_at', 'updated_at'],
            DB::table('demandes as d')
                ->leftJoin('users as u', 'u.id', '=', 'd.User_ayant_valide')
                ->where('d.etat', 1)
                ->whereNotNull('d.User_ayant_valide')
                ->whereNotNull('d.Date_etat_validation')
                ->select('d.User_ayant_valide', 'u.organisation', DB::raw("'validation'"), 'd.id', DB::raw('NULL'), 'd.Date_etat_validation', 'd.Date_etat_validation')
        );

        DB::table('journal_actions')->insertUsing(
            ['user_id', 'organisation', 'action', 'demande_id', 'detail', 'created_at', 'updated_at'],
            DB::table('historiques as h')
                ->join('users as u', 'u.id', '=', 'h.id_user')
                ->whereNotNull('u.isadmin')
                ->whereNotNull('h.created_at')
                // « Envoyer Pour Traitement » est le renvoi fait par le promoteur, pas un rejet d'agent
                ->where(fn ($q) => $q->whereNull('h.motif')->orWhere('h.motif', '!=', 'Envoyer Pour Traitement'))
                ->select('h.id_user', 'u.organisation', DB::raw("'rejet'"), 'h.id_demande', 'h.motif', 'h.created_at', 'h.created_at')
        );
    }

    public function down()
    {
        Schema::dropIfExists('journal_actions');
    }
}
