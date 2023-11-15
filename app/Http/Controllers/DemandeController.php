<?php

namespace App\Http\Controllers;

use App\Models\Usager; 
use App\Models\Demande;
use App\Models\DemandeDirigeant;
use App\Models\Terrain;
use App\Models\Prestation;
use App\Models\PieceJointe;
use App\Models\Valeur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;


class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
        //$this->middleware('auth', ['except' => ['verifier_nom_commercial']]);
        $this->middleware('auth')->except(['verifier_nom_commercial','index','test','liste_demande',
        'liste_demande_rejet','detail_backend','update_etat_demande']);
    }

    public function test()
    {        
        return view('test');
    }

    public function index()
    {
        $PP=Demande::where('company_type', "EI")->where('paye',1)->get();
        $PM=Demande::where('company_type', "ES")->where('paye',1)->get();
        $nbr_pp= count($PP);
        $nbr_pm= count($PM);
        $total= $nbr_pp+$nbr_pm;

        
        if(Auth::user()){
        $usager= Usager::where('user_id',Auth::user()->id)->first();
        //dd($usager);
        if($usager!=null){
        $demandes=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
        $c=count($demandes);
        return view('index', compact('nbr_pp','nbr_pm','total','c'));
        }
        else
        {
            $c=0;
            return view('index', compact('nbr_pp','nbr_pm','total','c'));
        }
    }
    else{
        return view('index', compact('nbr_pp','nbr_pm','total'));
        
    }
        //$demandes=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
        //$c=count($demandes);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user())
        {
        $usager= Usager::where('user_id',Auth::user()->id)->first();
        $demande_pp=Demande::where('usager_id', $usager->id)->where('company_type','EI')->get();
        $nbr_demande_pp=count($demande_pp);
        if($usager!=null){
            $piecejointe_enrs= PieceJointe::where('usager_id',$usager->id)->get();
            $regions= DB::table('regions')->get();
            $pays= DB::table('valeurs')->where('parametre_id',5)->get();
            $fonctions= DB::table('valeurs')->where('parametre_id',8)->get();
            $activites= DB::select('select secteur_activite from activites group by secteur_activite');
            $activites_secondaires= DB::table('activites')->orderby('description','asc')->get(); 
            $FJ_EI= DB::table('forme_juridiques')->where('company_type','EI')->get();
            $FJ_ES= DB::table('forme_juridiques')->where('company_type','ES')->get();
            $FJ_GIE= DB::table('forme_juridiques')->where('company_type','GIE')->get();
            $usage_terrains= DB::table('usage_terrains')->get();
            $all_usagers= Usager::all();
    
            $prestation_PPs= Prestation::where('type_demande','P1')->get();
            $prestation_PPs= $prestation_PPs->unique('type');
            $prestation_PMs= Prestation::where('type_demande','M1')->get();
            $prestation_PMs= $prestation_PMs->unique('type');      
    
            $demandes=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
            $c=count($demandes);
            return view('demande.test' ,compact('piecejointe_enrs','regions', 'pays','fonctions','activites','prestation_PPs','prestation_PMs',
            'FJ_EI','FJ_ES','FJ_GIE','usager','activites_secondaires','pays','all_usagers','usage_terrains','c','nbr_demande_pp'));
        }
        else{
            $c=0;
            return view('demande.test' ,compact('piecejointe_enrs','regions', 'pays','fonctions','activites','prestation_PPs','prestation_PMs',
            'FJ_EI','FJ_ES','FJ_GIE','usager','activites_secondaires','pays','all_usagers','usage_terrains','c','nbr_demande_pp'));
        }
        }
        //$usager= Usager::where('user_id',Auth::user()->id)->first();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->type_request);
        // Vérification du montant CPC
        //dd($request->all());
        $ccp=$request->ccp_es;
        //dd($ccp);
       if(isset($ccp)){
        //dd($request->ccp_es);
        //dd('vrai');
        $avecCPC=1;
        if($request->type_request=='M1' || $request->type_request=='G1'){
           $montant_demande= DB::table('montant_demandes')->where('type','M1')->where('avecCPC',1)->first();
            //dd($montant_demande->montant);
            $montant=$montant_demande->montant;
            $montant_total=$montant_demande->montant_total;
        }
   }
   else{
    $avecCPC=0;
    if($request->type_request=='M1' || $request->type_request=='G1'){
        $montant_demande= DB::table('montant_demandes')->where('type','M1')->where('avecCPC',0)->first();
        // dd($montant_demande->montant);        
     }
     elseif($request->type_request=='P1'){
        $montant_demande= DB::table('montant_demandes')->where('type','P1')->first();
         //dd($montant_demande->montant);
         $avecCPC=1;
     }
     $montant=$montant_demande->montant;
     $montant_total=$montant_demande->montant_total;
   }

   //dd($montant);
        $usager=DB::table('usagers')->where('user_id',Auth::user()->id)->first();

       // $num=$request->type_request.
        //Pour la signature        
            //$path = 'C:\wamp64/www/Zip Ecreation/Ecreation_sanou/storage/app/public/files/Signature/';
            $path='C:\wamp64/www/Ecreation/storage/app/public/files/'.$usager->id.'/';
         //$request->signed->store('public','upload');
        // $path = Storage::putFile('photos', new File('public/upload/'));
        // $path = $request->file('signed')->store('upload', 'public');
         $image_parts = explode(';base64,',$request->signed);
         $image_type_aux = explode('image/',$image_parts[0]);
         //dd($image_type_aux);
         $image_type = $image_type_aux[1];
         $image_base64 = base64_decode($image_parts[1]);
         //$file =$path.$usager->id.'.'.$image_type;
         $file =$path.'signature'.'.'.$image_type;

        // $file =$path.$image_type;
        //$file ='public/files/'.$usager->id.'-'.$usager->NomRaisonSociale.'.'.$usager->Prenom; 
        file_put_contents($file,$image_base64);
        //$url_signature=$file;
             
            //$url=$image_base64->store('public/files/');
            //Storage::put('storage/app/public/files/'.$usager->id.'-'.$usager->NomRaisonSociale.$usager->Prenom, $image_base64);
           // $file_url= $request['signed']->storeAs($emplacement, $fileName);
            //$url_local="Signature/".$usager->id.'.'.$image_type;
            $url_local=$usager->id.'/signature'.'.'.$image_type;
            //$docName = $type_doc;
            $type_doc="Signature";
           // $file = $request->file('piece_jointe_1')->storeAs('public/casier', $docName.'.'.$guessExtension);
            $piecejointe_enrs= PieceJointe::where('usager_id',$usager->id)->where('demande_id',null)->where('type_piece', $type_doc)->get();
           // dd(count($piecejointe_enrs));
        if(count($piecejointe_enrs)==0)
        {
            $date= new \Datetime();
            $pj= PieceJointe::create([
                'usager_id'=>$usager->id,
                'type_piece'=> $type_doc,
                'url'=> $file,
                'numero'=> '',
                'date_etablissement'=> $date,
                'lieu_etablissement' => 'test',
                'categorie_piece'=> 'Signature',
                'url_local'=>$url_local,
                'file_extension'=>$image_type
            ]);
        }
        
        $Cefore=DB::table('organisations')->where('CodeRegion', $request['region_entreprise'])->first();
        $Cefore_code=$Cefore->CodeOrganisation;
        
        $last_id=DB::table('demandes')->latest('id')->first();
        if($last_id){
            $nombre=$last_id->id+1;
        }
        else{
            $nombre=1;
        }
       
        $date = new \DateTime();
        $annee=date("Y", strtotime(now()));
        $code=str_replace(" ", "-", $Cefore_code);
        $numero=$request->type_request.'-'.$code.'-'.$annee.'-'.$nombre;

        $activites=DB::table('activites')->where('Code', $request['activite_principale'])->first();
        $category_code=$activites->category_code;
        if($request->type_request=='P1')
            {
            $company_type="EI";
            $forme_juridique=$request->forme_juridique_pp;
            }
        elseif($request->type_request=='M1'){
            $company_type="ES";
            $forme_juridique=$request->forme_juridique_es;
            }
        else{
            $company_type="ES";
            $forme_juridique=$request->forme_juridique_gie;
            }
        $secteur_village=DB::table('secteur_villages')->where('id',$request->secteur_entreprise)->first();
        //dd($secteur_village->code);
        $secteur_village=$secteur_village->code;
        $division=DB::table('secteur_villages')->where('code',$secteur_village)->first();
        $division_code=$division->division_fiscale_code;

        $terrain=Terrain::create([
            'id_terrain'=>0,
            'numero_lot'=>$request->lot,
            'numero_parcelle'=>$request->parcelle,
            'numero_section'=>$request->section,
            'id_secteur_village'=>$secteur_village,
            'type_terrain'=>$request->type_terrain,
            'id_usage_terrain'=>$request->usage,
            'id_usager'=>$usager->id,
            'superficie'=>$request->superficie

        ]);
           // dd($request->all());
        $demande= Demande::create([      
                 'type_entreprise' =>0,
                 'amount_timbre' =>0,
                 'organisation_code' =>$Cefore_code,
                 'request_type' =>$request->type_request,
                 'company_type' =>$company_type,
                 'type_adresse' => 0,
                 'confirm_request' => 0,
                 'usager_id' =>$usager->id,
                 'legal_representative' =>$usager->id,
                 'legal_rep_name' =>$usager->NomRaisonSociale.' '.$usager->Prenom,
                 'activity_category_code'=>$category_code,// à voir pour mettre
                 // 'origin_request_code' => $request[
                 //'serial_no' => $request[          
                 'nature_demande' => 1, // 1 pour création
                'nbre_actions' => $request['nombre_action'],
                'capital_en_numeraire' => $request['capital_en_numeraire'],
                'capital_en_nature' => $request['capital_en_nature'],
                'capital_social' => $request['montant_capital'],
                 'vie_societe_duree' => 99,
                 'montant_action' => $request['montant_action'],
                 //'seuil_min_capital' => $request[
                 'id_terrain' => $terrain->id,
                 'statut' =>0,
                 'institution_type' => $request['type_etablissement'],
                 'chiffre_daffaire_previsionel' => $request['chiffre_daffaire_previsionnel'], 
                 'taxation_regime' => 'CME',
                 'activity_sector' => $request['secteur_activite'],
                 'employee_permanant' => $request['employee_permanant'],
                 'employee_temporary' => $request['employee_temporaire'],
                 'employee_etranger' => $request['employee_etranger'],
                 'enseigne' => $request['enseigne'],
                 'commercial_name' => $request['nom_commercial'],
                 'sigle' => $request['sigle'],
                 'primary_activity' => $request['activite_principale'],
                 'begin_activity_date' => $date,
                 'denomination_social' => $request['nom_commercial'],
                 'region_code' => $request['region_entreprise'],
                 'province_code' => $request['province_entreprise'],
                 'commune_departement_code' => $request['commune_entreprise'],
                 'arrondissement_code' => $request['arrondissement_entreprise'],
                 'code_secteur_village' => $secteur_village,
                 'avenue' => $request['avenue'],
                 'boite_postale' => $request['boite_postale'],
                 'rue' => $request['rue'],
                 'pays' => $request['pays'],
                 'mobile_1' => $request['mobile_1'],
                 'tel_bureau' => $request['tel_bureau'],
                 'adress' => $request['adresse'],
                 'quartier' => $request['adresse'],
                 'porte' => 2, // Champs à revoir
                 'email' => $request['email'],
                 'home_page' => $request['site_web'], 
                 'mobile_2' => $request['mobile_1'],          
                 'division_fiscale_code' => $division_code,
                 'code_direction_impot' => 'test',
                 'forme_juridique' => $forme_juridique,
                 'signature_demandeur' => $path,        
                 'objet_social' => $request['objet_social'],
                 'avecCPC' =>  $avecCPC,
                'montant' =>  $montant,
                //'etat'=>0,
                'numero_demande'=>$numero,
                'paye'=>0,
                'montant_total'=>$montant_total
        ]);
        //dd($demande);
        // Mise à jour de la table pièce jointe
        $pieces= PieceJointe::where('usager_id',$usager->id)->where('demande_id',null)->where('categorie_piece', '!=' ,'piece_didentite')->get();
            foreach($pieces as $piece){
                $piece->update([
                    'demande_id'=> $demande->id
                ]);
            }

            if($request->type_request!='P1')
            {
                $associes=$request->associes;
                $fonction_associes=$request->fonction_associes;
                $capital_associes=$request->capital_associes;
                $commissaire=$request->commissaire;
                $qualite_commissaire=$request->qualite_commissaire;
                for($i=0; $i<count($associes); $i++){
                    if($associes[$i]!="" && $fonction_associes[$i]!="" && $capital_associes[$i]!=""){
                        DemandeDirigeant::create([
                            'demande_id'=>$demande->id,
                            'usager_id'=>$associes[$i],
                            'pourcentage_capital'=>$capital_associes[$i],
                            'personne_pouvant_engager'=>0,
                            'type'=>2,
                            'fonction_code'=>$fonction_associes[$i],                                
                    ]);
                    }
                }
                // $commissaire=$request->commissaire;
                // $qualite_commissaire=$request->qualite_commissaire;
                
                for($i=0; $i<count($commissaire); $i++)
                {
                    if($commissaire[$i]!="" && $qualite_commissaire[$i]!="")
                    {
                        // if($qualite_commissaire[$i]="Titulaire"){
                        //     $qualite_commissaire[$i]=0;
                        // }
                        // else{
                        //     $qualite_commissaire[$i]=1;
                        // }
                        DemandeDirigeant::create([
                            'demande_id'=>$demande->id,
                            'usager_id'=>$commissaire[$i],
                            'pourcentage_capital'=>0,
                            'personne_pouvant_engager'=>0,
                            'type'=>4,
                            'qualite'=>$qualite_commissaire[$i],                                
                    ]);
                    }
                }
                
                if($request->notaire!=""){
                    DemandeDirigeant::create([
                        'demande_id'=>$demande->id,
                        'usager_id'=>$request->notaire,
                        'pourcentage_capital'=>0,
                        'personne_pouvant_engager'=>0,
                        'type'=>3,                                                        
                ]);
                }
                if($request->dirigeant!=""){
                    DemandeDirigeant::create([
                        'demande_id'=>$demande->id,
                        'usager_id'=>$request->dirigeant,
                        'pourcentage_capital'=>$request->capital_dirigeant,
                        'personne_pouvant_engager'=>0,
                        'type'=>1,
                        'fonction_code'=>$request->fonction_dirigeant_p,                                                 
                ]);
                }
            }
            //  '' => $request['activite_principale'],
            $activites=DB::table('activites')->where('Code', $demande->primary_activity)->first();
            $forme_juridique=DB::table('forme_juridiques')->where('code', $demande->forme_juridique)->first();
            $usager=Usager::where('id', $demande->usager_id)->first();
            $demande_dirigeant=DB::table('demande_dirigeants')->where('demande_id', $demande->id)->first();
            $regions=DB::table('regions')->where('id', $demande->region_code)->first();
            $provinces=DB::table('provinces')->where('id', $demande->province_code)->first();
            $communes=DB::table('commune_departements')->where('id', $demande->commune_departement_code)->first();
            $arrondissements=DB::table('arrondissements')->where('id', $demande->arrondissement_code)->first();
            $secteurs=DB::table('secteur_villages')->where('code', $demande->code_secteur_village)->first();

            if($demande_dirigeant){
                $dirigeants=$demande_dirigeant;
                $usager_diri=$dirigeants->usager_id;
                $diri=Usager::where('id', $usager_diri)->first();
                $dirigeants=$diri;
                //dd($dirigeants);
                }
                else{
                    $dirigeants=$usager;
                }
            
                $dem=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
                $c=count($dem);

            return view('demande.transition', compact('demande','activites','forme_juridique','dirigeants',
        'regions','provinces','communes','secteurs','c'));
        
        //return back() ;
    }
    public function  modifier(Request $request){
        $usager= Usager::where('user_id',Auth::user()->id)->first();
        $piecejointe= PieceJointe::where('usager_id',$usager->id)->where('demande_id',null)->where('categorie_piece', $request->categoriepiece)->first();
        $data = array(
         'id'=>$piecejointe->id,
         'type_piece'=>$piecejointe->type_piece,
         'categorie_piece'=>$piecejointe->categorie_piece,
         'reference'=>$piecejointe->numero,
         'date_etablissement'=> format_date($piecejointe->date_etablissement),
         'lieu_etablissement'=>$piecejointe->lieu_etablissement,
     );
     return json_encode($data);
 }
 public function verifier_nom_commercial(Request $request){
    if (isset($request['nom_commercial'])) {
        $nom_commercial = $request['nom_commercial'];
    }
    $client = new \GuzzleHttp\Client([
        'verify' => false
    ]);
    //$token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpcCI6IiIsInVpZCI6IjEwMDAiLCJ1c2VybmFtZSI6Im1lYmYuZWNyZWF0aW9uIiwiZW1haWwiOiJtZWJmLmVjcmVhdGlvbkBtZS5iZiIsImV4cCI6MTY4MDg3ODM5OH0.BUkk2_9bq1uFyASMdDGBQMdAdd79TjiN1_4Vi18phRE';
    //$token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpcCI6IiIsInVpZCI6IjEwMDAiLCJ1c2VybmFtZSI6Im1lYmYuZWNyZWF0aW9uIiwiZW1haWwiOiJtZWJmLmVjcmVhdGlvbkBtZS5iZiIsImV4cCI6MTY4MjI2NTQ2OX0.imp8JNP8GwYTaU1ROB5a2L_XePyvudeMMMteQaNPaaM';
    //$token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpcCI6IiIsInVpZCI6IjEwMDAiLCJ1c2VybmFtZSI6Im1lYmYuZWNyZWF0aW9uIiwiZW1haWwiOiJtZWJmLmVjcmVhdGlvbkBtZS5iZiIsImV4cCI6MTY4NjQyNzIzMH0.6WOx9JkPH6z0QNE7Q8nhzEDfcWFbU1Ke98XHzkDB9cI';
    $token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpcCI6IiIsInVpZCI6IjEwMDAiLCJ1c2VybmFtZSI6Im1lYmYuZWNyZWF0aW9uIiwiZW1haWwiOiJtZWJmLmVjcmVhdGlvbkBtZS5iZiIsImV4cCI6MTY5ODk0MTIwNH0.ZiWMSuKsRMOHjhfg9ngtQH-sGKjYgH-Rvny4QnTNWsw';
    // $res = $client->request (
    //     'POST',
    //     'http://fichiernationalrccm.com/api/auth/token', [
    //         'headers' => [
    //             'Authorization' => 'Basic mebf.ecreation:mebfERP@Ecrat1',
    //             'Accept' => 'application/json',
    //         ],
    // ]);
    // dd($res);
    $response = $client->request (
        'POST',
        'https://fichiernationalrccm.com/api/registres/verifync', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json',
            ],
        'form_params' => [
            'keywords' => $nom_commercial,
        ]
    ]);
         $responses = json_decode ($response->getBody ());
            return  $responses;
 }

public function laodpiecejointe(Request $request){
$usager= Usager::where('user_id',Auth::user()->id)->first();
//dd($request->type_document_identite);
    if($request->type_document){
            $type_doc= $request->type_document;
        }
        elseif($request->type_document_identite){
            $type_doc=$request->type_document_identite;
        }
        else{ 
            $type_doc=$request->type_doc;
        }
      // dd($request->all());
        if($request->hasFile('piece_jointe_1')) {
            $file = $request->file('piece_jointe_1');
            $extension=$file->getClientOriginalExtension();
            //$file_extension='application/'.$extension;
            $pj_nbre= PieceJointe::where('usager_id', $usager->id)->where('type_piece',$type_doc)->get();
            //$pj_nbre);
            $nbr_piece=count($pj_nbre)+1;
            //dd($nbr_piece);
            $fileName = $nbr_piece.'-'.$type_doc.'.'.$extension;
            //Definir l'emplacement de sorte à créer un sous repertoire pour chaque entreprise
           // $fileName = $file->getClientOriginalName();

            $emplacement='public/files/'.$usager->id; 
            $file_url= $request['piece_jointe_1']->storeAs($emplacement, $fileName);
            $url_local= $usager->id.'/'.$fileName;
            $docName = $type_doc;
           // $file = $request->file('piece_jointe_1')->storeAs('public/casier', $docName.'.'.$guessExtension);
           //dd($usager->id);
            $piecejointe_enrs= PieceJointe::where('usager_id',$usager->id)->where('demande_id',null)->where('type_piece', $type_doc)->get();
           //dd($piecejointe_enrs);
        if(count($piecejointe_enrs)==0)
        {
            $pj= PieceJointe::create([
                'usager_id'=>$usager->id,
                'type_piece'=> $type_doc,
                'url'=> $file_url,
                'numero'=> $request->numero_ref,
                'date_etablissement'=> $request->date_detablissment,
                'lieu_etablissement' => $request->lieu_etablissment,
                'categorie_piece'=> $request->categorie_piece,
                'url_local'=>$url_local,
                'file_extension'=>$extension
            ]);
        }
        }
        if ($pj) {
            $data_json= array('data'=>'success','status'=>'201', 'type_doc'=>$type_doc);
            return json_encode($data_json);
        }
        else{
            $data_json = array('data'=>'fail','status'=>'400', 'type_doc'=>$type_doc);
            return json_encode($data_json);
        }
    }
    public function updatepiecejointe(Request $request){
        $usager= Usager::where('user_id',Auth::user()->id)->first();
        if($request->type_document){
            $type_doc= $request->type_document;
        }
        elseif($request->type_document_identite){
            $type_doc=$request->type_document_identite;
        }
        else{
            $type_doc=$request->type_doc;
        }
      
        if ($request->hasFile('piece_jointe_u')) {
            $piecejointe= PieceJointe::find($request->piece_id);
           
            if($type_doc==null){
                $type_doc=$piecejointe->type_piece;
            }
            
            $file = $request->file('piece_jointe_u');
            $extension=$file->getClientOriginalExtension();
            $fileName = $type_doc.'.'.$extension;
            //Definir l'emplacement de sorte à créer un sous repertoire pour chaque entreprise
           // $fileName = $file->getClientOriginalName();

            $emplacement='public/files/'.$usager->id;
            $file_url= $request['piece_jointe_u']->storeAs($emplacement, $fileName);
            $url_local=$usager->id.'/'.$fileName;
           
            $pj= $piecejointe->update([
                'type_piece'=> $type_doc,
                'url'=> $file_url,
                'numero'=> $request->numero_ref,
                'date_etablissement'=> $request->date_detablissment,
                'lieu_etablissement' => $request->lieu_etablissment,
                'url_local'=>$url_local
               // 'categorie_piece'=> $request->categorie_piece
            ]);
        
        }
        if ($pj) {
            $data_json= array('data'=>'success','status'=>'201', 'type_doc'=>$type_doc);
            return json_encode($data_json);
        }
        else{
            $data_json = array('data'=>'fail','status'=>'400', 'type_doc'=>$type_doc);
            return json_encode($data_json);
        }
    }
    public function detaildocument(Request $request){
       // $typedoc=$request->typedocument;
       //$filename='test';
       
       $usager= Usager::where('user_id',Auth::user()->id)->first();
       //$demande=Demande::where('usager_id',$usager->id)->first();
       $piecejointe= PieceJointe::where('usager_id',$usager->id)
       ->where('categorie_piece', $request->categoriepiece)
       ->where('demande_id', null)
       ->first();
        // return Response::make(file_get_contents($piecejointe->url), 200, [
        //     'Content-Type' => 'application/pdf',
        //     'Content-Disposition' => 'inline; filename="' . $filename . '"'
        // ]);
       return $path = Storage::download($piecejointe->url);
       
    }
    public function getallpiecejointe(){
        $usager= Usager::where('user_id',Auth::user()->id)->first();
        $piecejointes= PieceJointe::where('usager_id',$usager->id)->get();
 
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function show(Demande $demande)
    {
        //
    }

    public function ourr(){
        return true;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function edit(Demande $demande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demande $demande)
    {
        //
    }

    public function liste()
        {

            $usager= Usager::where('user_id',Auth::user()->id)->first();
            $demandes=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
            $c=count($demandes);
            return view('demande.liste', compact('demandes','c'));
        }

        public function detail($id)
        {
            // $usager= Usager::where('user_id',Auth::user()->id)->first();
            
            $demandes=Demande::where('id', $id)->first();
            $usager=Usager::where('id', $demandes->usager_id)->first();
           $activites= DB::table('activites')->where('Code', $demandes->primary_activity)->first();
           $forme_juridiques= DB::table('forme_juridiques')->where('code', $demandes->forme_juridique)->first();
           $professions= Valeur::where('code', $usager->IdFonction)->first();
           $regions=DB::table('regions')->where('id', $demandes->region_code)->first();
           $provinces=DB::table('provinces')->where('id', $demandes->province_code)->first();
           $communes=DB::table('commune_departements')->where('id', $demandes->commune_departement_code)->first();
           $arrondissements=DB::table('arrondissements')->where('id', $demandes->arrondissement_code)->first();
           $secteurs=DB::table('secteur_villages')->where('code', $demandes->code_secteur_village)->first();
           $terrains=DB::table('terrains')->where('id', $demandes->id_terrain)->first();
           $piecejointes= PieceJointe::where('usager_id',$usager->id)->where('demande_id', $demandes->id)->get();
            $secteur_usager=DB::table('secteur_villages')->where('code', $usager->Code_Secteur_Village)->first();
            $province_usager=DB::table('provinces')->where('id', $usager->Province_Code)->first();
            $region_usager=DB::table('regions')->where('id', $usager->Region_Code)->first();
           //$nationalite= Valeur::where('parametre_id', 5)->where('code', $usager->Nationality_No_)->first();
        
           //    DB::table('activites')->where('id', $demandes->primary_activity)->first();
           $demande=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
           $c=count($demande);
           $cefore=DB::table('organisations')->where('CodeOrganisation',$demandes->organisation_code)->first();
            $cefore_code=$cefore->Ville;
            return view('demande.detailtest', compact('demandes','usager','activites','forme_juridiques',
            'professions','regions','provinces','communes','arrondissements','secteurs','terrains','piecejointes',
        'secteur_usager','province_usager','region_usager','c','cefore_code'));       
        
        }

        public function valider_paiement (Request $request)
        {
            //dd($request->all());
            $date=new \DateTime();
            //$id=$request->id;
            $date_paiement= $date->format("d-m-Y H:i:s");
            $numero_demande=$request->num_command;
            $numero=substr($numero_demande, 0, -6);
            //dd($numero);    
           $demande=Demande::where('numero_demande',$numero)->first();
           $usager=Usager::where('id',$demande->usager_id)->first();
           $demande->update([
            'paye'=>1,
            'date_paiement'=>$date_paiement
           ]);
            //return redirect()->back();
            //$pdf = PDF::loadView('pdf.facture', compact('demande','usager'));
            //return view('pdf.facture', compact('demande','usager'));
            //return $pdf->download('cefore_facture.pdf');
            //return view('pdf.facture', compact('demande'));
            return redirect()->route('demande.liste');
        }
        public function facture($id)
        {
            $demande=Demande::where('id', $id)->first();
            $usager=Usager::where('id', $demande->usager_id)->first();
            $content = $demande->numero_demande.'
'.$usager->NomRaisonSociale.' '.$usager->Prenom; // Remplacez par le contenu que vous souhaitez dans le code QR.
            $qrCode_simple = QrCode::generate($content);
            $qrCode=base64_encode($qrCode_simple);
            $pdf = PDF::loadView('pdf.facture', compact('demande','usager','qrCode'));
            // $type=$demande->request_type;
            // $cpc=$demande->avecCPC;
            // if($type=="P1"){
            //     $montant=$demande->montant+880;
            // }
            //return view('pdf.facture', compact('demande','usager','qrCode'));
            return $pdf->download('cefore_facture.pdf');
        }

        public function update_demande(Request $request, $id)
        {//
            $demande=Demande::find($id);
            $demande->commercial_name=$request->nom_commercial;
            $demande->enseigne=$request->enseigne;
            $demande->sigle=$request->sigle;
            //$demande->denomination_social=$request->denomination_sociale;
            $demande->chiffre_daffaire_previsionel=$request->chiffre_daffaire;
            //$demande->sigle=$request->objet_social;
            $demande->update();
            return redirect()->back();
        }

        public function index_admin(){
            $demandes=Demande::all();
            $paye=Demande::where('paye', 1)->get();
            $nbr_paye=count($paye);
            $nonpaye=Demande::where('paye', 0)->get();
            $rejet=Demande::where('etat', 0)->get();
            $nbr_rejet=count($rejet);
            $nbr_nonpaye=count($nonpaye);
            $nbr=count($demandes);
            return view('backend.adminlte.dashboard', compact('demandes','nbr','nbr_paye','nbr_nonpaye','nbr_rejet'));
        }

        public function liste_demande(){
            $demandes=Demande::all();
            return view('backend.adminlte.liste', compact('demandes'));
        }
        public function liste_demande_rejet(){
            $demandes=Demande::where('etat', 0)->get();
            return view('backend.adminlte.liste_rejet', compact('demandes'));
        }

        public function detail_backend($id)
        {
            $demandes=Demande::where('id', $id)->first();
            $usager=Usager::where('id', $demandes->usager_id)->first();
           $activites= DB::table('activites')->where('Code', $demandes->primary_activity)->first();
           $forme_juridiques= DB::table('forme_juridiques')->where('code', $demandes->forme_juridique)->first();
           $professions= Valeur::where('code', $usager->IdFonction)->first();
           $regions=DB::table('regions')->where('id', $demandes->region_code)->first();
           $provinces=DB::table('provinces')->where('id', $demandes->province_code)->first();
           $communes=DB::table('commune_departements')->where('id', $demandes->commune_departement_code)->first();
           $arrondissements=DB::table('arrondissements')->where('id', $demandes->arrondissement_code)->first();
           $secteurs=DB::table('secteur_villages')->where('code', $demandes->code_secteur_village)->first();
           $terrains=DB::table('terrains')->where('id', $demandes->id_terrain)->first();
           $piecejointes= PieceJointe::where('usager_id',$usager->id)->where('demande_id', $demandes->id)->get();
            $secteur_usager=DB::table('secteur_villages')->where('code', $usager->Code_Secteur_Village)->first();
            $province_usager=DB::table('provinces')->where('id', $usager->Province_Code)->first();
            $region_usager=DB::table('regions')->where('id', $usager->Region_Code)->first();
           $demande=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
           $c=count($demande);
           $cefore=DB::table('organisations')->where('CodeOrganisation',$demandes->organisation_code)->first();
            $cefore_code=$cefore->Ville;
            return view('backend.adminlte.detail', compact('demandes','usager','activites','forme_juridiques',
            'professions','regions','provinces','communes','arrondissements','secteurs','terrains','piecejointes',
        'secteur_usager','province_usager','region_usager','c','cefore_code'));       
    }

        public function valider_demande(Request $request , $id){
            $demandes=Demande::find($id);
            $etat=$request->etat;
            $motif=$request->motif;
            $date=new \DateTime();
            $date_validation= $date->format("d-m-Y H:i:s");
            if($etat=="oui"){                
                $demandes->update([
                    'etat'=>1,
                    'Date_etat_validation'=>$date_validation,
                    'User_ayant_valide'=>Auth::user()->id
                   ]);
                   return redirect()->route('list');
            }
            else{
                $demandes->update([
                    'etat'=>0,
                    'motif'=>$motif,
                    'Date_etat_validation'=>$date_validation,
                    'User_ayant_valide'=>Auth::user()->id
                   ]);
                   return redirect()->route('list');
            }
        }
}
