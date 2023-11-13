<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Parametre;

class TestController extends Controller
{
    public function syncrodata(){
        $parametre = new Parametre;
        $parametre->setConnection('sqlsrv');
       // return $parametre->get();

        $parametres =Parametre::get();

    
        dd($parametres);
        foreach($parametres as $parametre){
            Parametre::create([
                'libelle'=>$parametre->libelle,
                'description'=>$parametre->description
            ]);
        }
    }
}
