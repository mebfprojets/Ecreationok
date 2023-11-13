<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creas', function (Blueprint $table) {
            $table->id();
       
            $table->string("Nom");
            $table->string("Prenom");
            $table->string("Email");
            $table->string("Phone");
            $table->string("address");
          
            $table->string("card_number");
            $table->integer("number_credit");
           
            $table->string("declaration");
            $table->date("company");
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
        Schema::dropIfExists('creas');
    }
}
