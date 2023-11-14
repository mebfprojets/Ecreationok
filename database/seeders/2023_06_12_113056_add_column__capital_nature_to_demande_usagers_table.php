<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCapitalNatureToDemandeUsagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demande_usagers', function (Blueprint $table) {
            //
           $table->bigInteger('capital_en_nature')->nullable(); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande_usagers', function (Blueprint $table) {
            //
            $table->dropColumn('capital_en_nature');

        });
    }
}
