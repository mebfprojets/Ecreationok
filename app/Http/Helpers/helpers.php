<?php
use App\Models\PieceJointe;
use App\Models\Demande;
use App\Models\Usager;
use App\Models\Valeur;
use App\Models\Formalite;
use Illuminate\Support\Facades\Auth;

if (!function_exists('returnpieceinfos')) {
    function returnpieceinfos($categorie_piece)
        {
            $usager= Usager::where('user_id',Auth::user()->id)->first();
            //$piecejointe= PieceJointe::where('usager_id',$usager->id)->where('categorie_piece', $categorie_piece )->first();
            // if($categorie_piece != 'piece_didentite'){
                $piecejointe= PieceJointe::where('usager_id',$usager->id)->where('demande_id',null)->where('categorie_piece', $categorie_piece )->first();
            // }
            // else{
            //     $piecejointe= PieceJointe::where('usager_id',$usager->id)->where('categorie_piece', $categorie_piece )->first();
            // }
            if($piecejointe){
                return true;
            }
            else{
                return false;
            }
           
        }
    }
    if(!function_exists('format_date')){
        function format_date($date){
            return  date('d-m-Y', strtotime($date));
        }
    }
    if(!function_exists('format_date2')){
        function format_date2($date){
            return  date('Y-m-d', strtotime($date));
        }
    }
    if(!function_exists('nbr_demande')){
        function nbr_demande(){
            $c=0;
            if(Auth::user()){
                $usager= Usager::where('user_id',Auth::user()->id)->first();
                //dd($usager);
                if($usager!=null){
                $demandes=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
                $c=count($demandes);
                
            }
            return  $c;
        }
    }
    }

    if (!function_exists('getlibelle')) {
        function getlibelle($id)
            {
                $record = Valeur::where('id', $id)->first();
                $libelle = isset($record['libelle']) ? $record['libelle'] : "";
                    return $libelle;
            }
        }

        if (!function_exists('getfonction')) {
            function getfonction($id)
                {
                    $record = Valeur::where('code', $id)->where('parametre_id', 8)->first();
                    $libelle = isset($record['libelle']) ? $record['libelle'] : "";
                        return $libelle;
                }
            }
    
        if (!function_exists('getpays')) {
            function getpays($code)
                {
                    $record = Valeur::where('code', $code)->first();
                    $libelle = isset($record['libelle']) ? $record['libelle'] : "";
                        return $libelle;
                }
            }
        
            if (!function_exists('getelementformalite')) {
                function getelementformalite($id_demande, $id_formalite)
                    {   $array=array("numero" => '', "date" => '');
                        $demandes=Demande::where('id', $id_demande)->first();
                        $get_val=Valeur::where('id', $id_formalite)->first();
                        $get_formalite=$get_val->libelle;
                        if($get_formalite=="RCCM"){
                            $formalites=$demandes->RCCM;
                            $date=$demandes->DateRCCM;                  
                             $array = array("numero" => $formalites, "date" => $date);
                            //dd($array);
                            //return $array;
                        }
                        if($get_formalite=="IFU"){
                            $formalites=$demandes->IFU;
                            $date=$demandes->DateIFU;                  
                            $array = array("numero" => $formalites, "date" => $date);
                            //dd($array);                            
                        }
                        if($get_formalite=="CNSS"){
                            $formalites=$demandes->CNSS;
                            $date=$demandes->DateCNSS;                  
                            $array = array("numero" => $formalites, "date" => $date);
                            //dd($array);                            
                        }
                        if($get_formalite=="CPC"){
                            $formalites=$demandes->CPC;
                            $date=$demandes->DateCPC;                 
                            $array = array("numero" => $formalites, "date" => $date);
                            //dd($array);                            
                        }
                        return $array;
                    }
                }

                if (!function_exists('getpieceformalite')) {
                    function getpieceformalite($id_demande, $id_formalite)
                        {
                            $valeur=Formalite::where('typepiece', $id_formalite)->where('demande_id', $id_demande)->first();
                            $id=$valeur->id;
                            return $id;
                        }
                    }

            if (!function_exists('getformalite')) {
                function getformalite($typepiece,$demandeId)
                    {
                        $formalite = Formalite::where('demande_id', $demandeId)->where('typepiece', $typepiece)->first();
                        return $formalite;
                    }
                }
    
?>