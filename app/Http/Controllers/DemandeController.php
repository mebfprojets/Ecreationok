<?php

namespace App\Http\Controllers;

use App\Models\Usager;
use App\Models\Paiement;
use App\Models\User;
use App\Models\Historique;
use App\Models\Demande;
use App\Models\DemandeDirigeant;
use App\Models\Terrain;
use App\Models\Prestation;
use App\Models\PieceJointe;
use App\Models\Valeur;
use App\Models\Formalite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\NotifyRejet;
use App\Mail\NotifyValider;
use Illuminate\Support\Facades\Mail;
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
        $this->middleware('auth')->except(['verifier_nom_commercial','index','test','reponse_paiement','fnrccm']);
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
        //Nombre de demande du mois
        $nbr_mois = Demande::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->where('paye', 1)
                ->count();

       //dd($nbr_mois);

        
        if(Auth::user()){
        $usager= Usager::where('user_id',Auth::user()->id)->first();
        //dd($usager);
        if($usager!=null){
        $demandes=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
        $c=count($demandes);
        return view('index', compact('nbr_pp','nbr_pm','total','c','nbr_mois'));
        }
        else
        {
            $c=0;
            return view('index', compact('nbr_pp','nbr_pm','total','c','nbr_mois'));
        }
    }
    else{
        return view('index', compact('nbr_pp','nbr_pm','total','nbr_mois'));
        
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
            $civilites=DB::table('valeurs')->where('parametre_id',15)->get();
    
            $prestation_PPs= Prestation::where('type_demande','P1')->get();
            $prestation_PPs= $prestation_PPs->unique('type');
            $prestation_PMs= Prestation::where('type_demande','M1')->get();
            $prestation_PMs= $prestation_PMs->unique('type');      
    
            $demandes=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
            $c=count($demandes);
            return view('demande.test' ,compact('piecejointe_enrs','regions', 'pays','fonctions','activites','prestation_PPs','prestation_PMs',
            'FJ_EI','FJ_ES','FJ_GIE','usager','activites_secondaires','pays','all_usagers','usage_terrains','c','nbr_demande_pp','civilites'));
        }
        else{
            $c=0;
            return view('demande.test' ,compact('piecejointe_enrs','regions', 'pays','fonctions','activites','prestation_PPs','prestation_PMs',
            'FJ_EI','FJ_ES','FJ_GIE','civilites','usager','activites_secondaires','pays','all_usagers','usage_terrains','c','nbr_demande_pp'));
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
       //dd($request->all());
        // Vérification du montant CPC
        $provinces_ss_ifus= Valeur::where('parametre_id',19)->get();
        foreach($provinces_ss_ifus as $province){
            $list_code[]=$province->code;
        }
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
            if(in_array($request['province_entreprise'],$list_code)){
                $montant= $montant - env('montant_societaire_ss_ifu');
                $frais=$montant*2/100;
                $montant_total= $montant + $frais;
                //$montant_total= $montant_total - env('montant_societaire_ss_ifu');
            }
        }
   }
   else{
    $avecCPC=0;
    if($request->type_request=='M1' || $request->type_request=='G1'){
        $montant_demande= DB::table('montant_demandes')->where('type','M1')->where('avecCPC',0)->first();
        $montant=$montant_demande->montant;
        $montant_total=$montant_demande->montant_total;
        if(in_array($request['province_entreprise'],$list_code)){
            $montant= $montant - env('montant_societaire_ss_ifu');
            $frais=$montant*2/100;
            $montant_total= $montant + $frais;
            //$montant_total= $montant_total - env('montant_societaire_ss_ifu');
        }    
     }
     elseif($request->type_request=='P1'){
        $montant_demande= DB::table('montant_demandes')->where('type','P1')->first();
         $avecCPC=1;
         $montant=$montant_demande->montant;
            $montant_total=$montant_demande->montant_total;
            if(in_array($request['province_entreprise'],$list_code)){
                $montant= $montant - env('montant_individuel_ss_ifu');
                $frais=$montant*2/100;
                $montant_total= $montant + $frais;
                //$montant_total= $montant_total - env('montant_societaire_ss_ifu');
            }
     }
    
   }
   //dd($montant_total);
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
        $code_command=str_replace(" ", "", $Cefore_code);
        $numero=$request->type_request.'-'.$code.'-'.$annee.'-'.$nombre;       
        $num_command=$request->type_request.$code_command.$annee.$nombre;

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

           if($request->denomination_sociale!=""){
            $denomination=$request->denomination_sociale;
           }
           else{
            $denomination=$request->nom_commercial;
           }
        $nomcom=Demande::where('commercial_name', $request->nom_commercial)->first();
        $denom=Demande::where('denomination_social', $denomination)->first();
        if($nomcom || $denom)
        {
            //dd($denom->primary_activity);
            $usager= Usager::where('user_id',Auth::user()->id)->first();
            $demandes=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
            $c=count($demandes);
            return view('demande.liste', compact('demandes','c'));
        }
        else{

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
                 'legal_rep_name' =>strtoupper($usager->NomRaisonSociale).' '.strtoupper($usager->Prenom),
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
                 'commercial_name' => strtoupper($request['nom_commercial']),
                 'sigle' => strtoupper($request['sigle']),
                 'primary_activity' => $request['activite_principale'],
                 'begin_activity_date' => $date,
                 'denomination_social' => strtoupper($request['nom_commercial']),
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
                 //'objet_social' => strtoupper($request['objet_social']),
                 'objet_social' => mb_strtoupper($request['objet_social'], 'UTF-8'),
                 'avecCPC' =>  $avecCPC,
                'montant' =>  $montant,
                'etat'=>0,
                'numero_demande'=>$numero,
                'numero_command'=>$num_command,
                'paye'=>0,
                'montant_total'=>$montant_total
        ]);
        //dd($demande);
        // Mise à jour de la table pièce jointe
        $pieces= PieceJointe::where('usager_id',$usager->id)->where('demande_id',null)->get();
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
        }
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
 public function correct_piece(Request $request){
    $usager= Usager::where('user_id',Auth::user()->id)->first();
    $piecejointe= PieceJointe::where('usager_id',$usager->id)->where('categorie_piece', $request->categoriepiece)->first();
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
public function updatepj_correct(Request $request){
    $usager= Usager::where('user_id',Auth::user()->id)->first();
    if ($request->hasFile('piece_jointe')) {
        $piecejointe= PieceJointe::find($request->piece_id_correct);
        $file = $request->file('piece_jointe');
        $extension=$file->getClientOriginalExtension();
        $fileName = $piecejointe->type_piece.'.'.$extension;
        $emplacement='public/files/'.$usager->id;
        $file_url= $request['piece_jointe']->storeAs($emplacement, $fileName);
        $url_local=$usager->id.'/'.$fileName;
        $pj= $piecejointe->update([
            'url'=> $file_url,
            'numero'=> $request->numero_ref,
            'date_etablissement'=> $request->date_detablissment,
            'lieu_etablissement' => $request->lieu_etablissment,
            'url_local'=>$url_local
           // 'categorie_piece'=> $request->categorie_piece
        ]);
    
    }
    if ($pj) {
       // $data_json= array('data'=>'success','status'=>'201', 'type_doc'=>$type_doc);
        return redirect()->back();
    }
    
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
    //$token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpcCI6IiIsInVpZCI6IjEwMDAiLCJ1c2VybmFtZSI6Im1lYmYuZWNyZWF0aW9uIiwiZW1haWwiOiJtZWJmLmVjcmVhdGlvbkBtZS5iZiIsImV4cCI6MTcwMTMwNzQ3OX0.BPZZ7dJwiy7c7-xU8hMqqrsroxqPWVOSp6UtwZMRAEo';
    // $res = $client->request (
    //     'POST',
    //     'http://fichiernationalrccm.com/api/auth/token', [
    //         'headers' => [
    //             'Authorization' => 'Basic mebf.ecreation:mebfERP@Ecrat1',
    //             'Accept' => 'application/json',
    //         ],
    // ]);
    // dd($res);

    $acces= base64_encode("mebf.ecreation:mebfERP@Ecrat1");
       // dd($acces);
    $res = $client->request (
        'POST',
        'http://fichiernationalrccm.com/api/auth/token', [           
          
            'headers' => [
                'Authorization' => 'Basic '.$acces,
                'Accept' => 'application/json',
            ],
    ]);
    $Body=$res->getBody()->getContents();
    $json_decoded=json_decode($Body, true);
    if($json_decoded['status']=200){
    $token=$json_decoded['response'];
    //dd($token);
    }

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

    public function documentformalite($id){
        // $typedoc=$request->typedocument;
        //$filename='test';
       //dd($id);
        
        //$usager= Usager::where('user_id',Auth::user()->id)->first();
        //$demande=Demande::where('usager_id',$usager->id)->first();
        $piecejointe= Formalite::find($id);
        //->first();
         // return Response::make(file_get_contents($piecejointe->url), 200, [
         //     'Content-Type' => 'application/pdf',
         //     'Content-Disposition' => 'inline; filename="' . $filename . '"'
         // ]);
        return $path = Storage::download($piecejointe->url);
        
     }

    public function detaildocument_affiche($id){
        $piecejointe= PieceJointe::find($id);
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
            $regions_all=DB::table('regions')->get();
            $FJ_EI= DB::table('forme_juridiques')->where('company_type','EI')->get();
            $FJ_ES= DB::table('forme_juridiques')->where('company_type','ES')->get();
            $FJ_GIE= DB::table('forme_juridiques')->where('company_type','GIE')->get();
           //    DB::table('activites')->where('id', $demandes->primary_activity)->first();
           $activites_all= DB::select('select secteur_activite from activites group by secteur_activite');
           $usage_terrains= DB::table('usage_terrains')->get();
           $civilites=DB::table('valeurs')->where('parametre_id',15)->get();
           $demande=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
           $professions= DB::table('valeurs')->where('parametre_id',8)->orderby('libelle','asc')->get();
           $nationalites= DB::table('valeurs')->where('parametre_id',6)->orderby('libelle','asc')->get();
           $pays= DB::table('valeurs')->where('parametre_id',5)->orderby('libelle','asc')->get();
           $c=count($demande);
           $cefore=DB::table('organisations')->where('CodeOrganisation',$demandes->organisation_code)->first();
            $cefore_code=$cefore->Ville;
            $types_formalites=Valeur::where('parametre_id',18)->orderby('libelle','desc')->get();
            //dd($types_formalites);
            return view('demande.detailtest', compact('demandes','usager','activites','forme_juridiques',
            'professions','regions','provinces','communes','arrondissements','secteurs','terrains','piecejointes',
        'secteur_usager','province_usager','region_usager','c','cefore_code','regions_all','FJ_EI','FJ_ES','FJ_GIE',
    'activites_all','usage_terrains','civilites','professions','nationalites','pays','types_formalites'));   
  
        
        }

        public function valider_paiement (Request $request)
        {
            //dd($request->all());
            $date=new \DateTime();
            //$id=$request->id;
            $date_initiation= $date->format("d-m-Y H:i:s");
            $numero_demande=$request->num_command;
            $numero=substr($numero_demande, 0, -5);
            //dd($numero);    
           $demande=Demande::where('numero_command',$numero)->first();
           $usager=Usager::where('id',$demande->usager_id)->first();
           if($demande->date_initiation==null){
            $demande->update([               
                'date_initiation'=>$date_initiation
                ]);
           }
           if($demande->paye!="1"){
           $demande->update([
            'paye'=>2            
            ]);
            }           
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
            //dd($request->denomination_sociale);
            if($request->denomination_sociale==null)
            {
                $demande->denomination_social=$request->nom_commercial;
            }
            else{
                $demande->denomination_social=$request->denomination_sociale;
            }
            $demande->chiffre_daffaire_previsionel=$request->chiffre_daffaire;
            $demande->objet_social=$request->objet_social;
            if($request->forme_juridique_pp!=null){
                $forme_juridique=$request->forme_juridique_pp;
            }
            elseif($request->forme_juridique_es!=null){
                $forme_juridique=$request->forme_juridique_es;
            }
            elseif($request->forme_juridique_gie!=null){
                $forme_juridique=$request->forme_juridique_gie;
            }
            $demande->forme_juridique=$forme_juridique;
            $demande->activity_sector=$request->secteur_activite;
            $demande->primary_activity=$request->activite_principale;
            //$demande->region_code=$request->region_entreprise;
            //Mise à jour du terrain
            //dd($request->id_terrain);
            $terrain=Terrain::find($request->id_terrain);
            $terrain->numero_lot=$request->lot;
            $terrain->numero_section=$request->section;
            $terrain->numero_parcelle=$request->parcelle;
            $terrain->id_usage_terrain=$request->usage;
            $terrain->update();

            $demande->update();
            return redirect()->back();
           
        }

        public function update_usager(Request $request, $id)
        {//
            //dd($request->province_usager);
            $usager=Usager::find($id);                       
            $usager->update([
                'NomRaisonSociale'=>$request->nom,
                'Prenom'=>$request->prenom,
                'LieuNaissance'=>$request->lieu_naissance,
                'Phone_No_'=>$request->tel_mobile,
                'Tel_Bureau'=>$request->tel_bureau,
                'E-Mail'=>$request->mail,
                'Boite_postale'=>$request->boite_postale,
                'titre' => $request->civilite,
                'Civility' => $request->civilite,
                'IdFonction'=>$request->profession,
                'Nationality_No_'=>$request->nationalite_usager,
                'Country_Code'=>$request->pays_usager,
                'DateNaissance'=>$request->date_de_naissance,
                'SituationMatrimoniale'=>$request->situation_matrimoniale,
                // 'Region_Code'=>$request->region_usager,
                // 'Province_Code'=>$request->province_usager
               ]);
            return redirect()->back();
        }

        public function index_admin(){
            if (Auth::user()->can('lister.demande'))
            {
            if(Auth::user()->organisation!="001000"){
                $demandes=Demande::where('organisation_code',Auth::user()->organisation)->where('etat', '!=', null)->orderby('created_at','desc')
                //->take(1000)
                ->get();
                $demande_count=Demande::where('etat', '!=', null)->orderby('created_at','desc')
                ->get();
                $paye=Demande::where('paye', 1)->where('organisation_code',Auth::user()->organisation)->get();
                $nbr_paye=count($paye);
                $nonpaye=Demande::where('paye', 0)->where('organisation_code',Auth::user()->organisation)->get();
                $rejet=Demande::where('etat', 2)->where('organisation_code',Auth::user()->organisation)->get();
                $nbr_rejet=count($rejet);
                $nbr_nonpaye=count($nonpaye);
                $nbr=count($demande_count);
            }
            else{
                $demandes=Demande::where('etat', '!=', null)->orderby('created_at','desc')
                //->take(1000)
                ->get();
                $demande_count=Demande::where('etat', '!=', null)->orderby('created_at','desc')
                ->get();
                $paye=Demande::where('paye', 1)->get();
                $nbr_paye=count($paye);
                $nonpaye=Demande::where('paye', 0)->get();
                $rejet=Demande::where('etat', 2)->get();
                $nbr_rejet=count($rejet);
                $nbr_nonpaye=count($nonpaye);
                $nbr=count($demande_count);
            }
            return view('backend.adminlte.dashboard', compact('demandes','nbr','nbr_paye','nbr_nonpaye','nbr_rejet'));
        }
        else{
            flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
            return redirect()->back();
        }
        }

        public function liste_demande(Request $request){
            if (Auth::user()->can('lister.demande'))
            {
            if(Auth::user()->organisation!="001000"){
                $etat=$request->etat;
            if($etat==0){
                $dem="demande_a_valider";
                $demandes=Demande::where('paye', 1)->where('etat', 0)->where('organisation_code',Auth::user()->organisation)->orderby('date_paiement','desc')->get();
            return view('backend.adminlte.liste', compact('demandes','dem'));
            }
            else{
                $dem="demande_valider";
                $demandes=Demande::where('paye', 1)->where('etat', 1)->where('organisation_code',Auth::user()->organisation)->orderby('date_paiement','desc')->get();
            return view('backend.adminlte.liste', compact('demandes','dem'));

            }
            }
            else{
                $etat=$request->etat;
                if($etat==0){
                    $dem="demande_a_valider";
                    $demandes=Demande::where('paye', 1)->where('etat', 0)->orderby('date_paiement','desc')->get();
                return view('backend.adminlte.liste', compact('demandes','dem'));
                }
                else{
                    $dem="demande_valider";
                    $demandes=Demande::where('paye', 1)->where('etat', 1)->orderby('date_paiement','desc')->get();
                return view('backend.adminlte.liste', compact('demandes','dem'));

                }
            }
        }
        else{
            flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
            return redirect()->back();
        }
        }

        public function liste_en_attente_de_partenaire(){
            if (Auth::user()->can('lister.demande'))
            {
            if(Auth::user()->organisation=="001000"){
            $demandes=Demande::where('RCCM','!=',null)->get();
            $rccm =count(Demande::where('RCCM','=',null)->where('etat', 1)->get());
            $ifu=count(Demande::where('IFU','=',null)->where('etat', 1)->get());
            $cnss=count(Demande::where('CNSS','=',null)->where('etat', 1)->get());
            $cpc=count(Demande::where('CPC','=',null)->where('etat', 1)->get());
            }
            else{
            $demandes=Demande::where('RCCM','!=',null)->where('organisation_code',Auth::user()->organisation)->orderby('created_at','desc')->get();
            $rccm =count(Demande::where('RCCM','=',null)->where('etat', 1)->get());
            $ifu=count(Demande::where('IFU','=',null)->where('etat', 1)->get());
            $cnss=count(Demande::where('CNSS','=',null)->where('etat', 1)->get());
            $cpc=count(Demande::where('CPC','=',null)->where('etat', 1)->get());    
            }
            $dem="demande_en_attente_partenaire";
            return view('backend.adminlte.enattentedepartenaire', compact('demandes','dem','rccm','ifu','cnss','cpc'));
            
        }
        else{
            flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
            return redirect()->back();
        }

        }

        public function liste_demande_rejet(){
            if (Auth::user()->can('lister.demande'))
            {
            if(Auth::user()->organisation!="001000"){
                $demandes=Demande::where('etat', 2)->where('organisation_code',Auth::user()->organisation)->orderby('created_at','desc')->get();
                }
            else{
                $demandes=Demande::where('etat', 2)->orderby('created_at','desc')->get();
                }
            return view('backend.adminlte.liste_rejet', compact('demandes'));
             }
            else{
                flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
                return redirect()->back();
            }
        }

        public function detail_backend($id)
        {
            if (Auth::user()->can('lister.demande'))
            {
            $demandes=Demande::where('id', $id)->first();
            $usager=Usager::where('id', $demandes->usager_id)->first();
           $activites= DB::table('activites')->where('Code', $demandes->primary_activity)->first();
           $regions_all=DB::table('regions')->get();
           $nationalites= DB::table('valeurs')->where('parametre_id',6)->orderby('libelle','asc')->get();
           $civilites=DB::table('valeurs')->where('parametre_id',15)->get();
           $pays= DB::table('valeurs')->where('parametre_id',5)->orderby('libelle','asc')->get();
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
            $FJ_EI= DB::table('forme_juridiques')->where('company_type','EI')->get();
            $FJ_ES= DB::table('forme_juridiques')->where('company_type','ES')->get();
            $FJ_GIE= DB::table('forme_juridiques')->where('company_type','GIE')->get();
           $activites_all= DB::select('select secteur_activite from activites group by secteur_activite');
           $professions= DB::table('valeurs')->where('parametre_id',8)->orderby('libelle','asc')->get();
           $usage_terrains= DB::table('usage_terrains')->get();
           $demande=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
           $c=count($demande);
           $cefore=DB::table('organisations')->where('CodeOrganisation',$demandes->organisation_code)->first();
            $cefore_code=$cefore->Ville;
            $typepieceformaliteretours= Valeur::where('parametre_id',18)->get();
            return view('backend.adminlte.detail', compact('demandes','usager','activites','forme_juridiques',
            'professions','regions','provinces','communes','arrondissements','secteurs','terrains','piecejointes',
        'secteur_usager','province_usager','region_usager','c','cefore_code','FJ_EI','FJ_ES','FJ_GIE','activites_all',
    'usage_terrains','civilites','professions','pays','nationalites','regions_all','typepieceformaliteretours'));  
}
    else{
        flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
        return redirect()->back();
    }
    }


    public function add_formalite_retour(Request $request){
    if (Auth::user()->can('save_formalite_retour'))
        {
        if ($request->hasFile('copie_de_la_formalite')) {
            $file = $request->file('copie_de_la_formalite');
            $extension=$file->getClientOriginalExtension();
            $fileName = getlibelle($request->typepiece).'.'.$extension;
            $emplacement='public/files/formalite_retours/'.$request->demande;
            $file_url= $request['copie_de_la_formalite']->storeAs($emplacement, $fileName);
                Formalite::create([
                    'typepiece'=>$request->typepiece,
                    'demande_id'=>$request->demande,
                    'url'=> $file_url,
                   ]);
                   flash("La formalité a été enregistré avec success!!!")->error();
    }
    return redirect()->back();
}
else{
    flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
    return redirect()->back();
}
}


public function update_formalite_retour(Request $request){
    if (Auth::user()->can('save_formalite_retour'))
     {
        if ($request->hasFile('copie_de_la_formalite'))
            {
                    $file = $request->file('copie_de_la_formalite');
                    $extension=$file->getClientOriginalExtension();
                    $fileName = getlibelle($request->typepiece).'.'.$extension;
                    $emplacement='public/files/formalite_retours/'.$request->demande;
                    $file_url= $request['copie_de_la_formalite']->storeAs($emplacement, $fileName);
                    $formalite= Formalite::where('demande_id' ,$request->demande)->where('typepiece' ,$request->typepiece)->first();
                    $formalite->update([
                            'url'=> $file_url,
                    ]);
            }
            return redirect()->back();
        }
            else{
                flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
                return redirect()->back();
            }
}

public function show_formalite_retour(Formalite $formalite){
    if (Auth::user()->can('lister.demande'))
     {
    return view("demande.detailformalite", compact('formalite'));
}
else{
    flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
    return redirect()->back();
}
}

    public function valider_demande(Request $request , $id){
        if (Auth::user()->can('valider.demande'))
            {
            $demandes=Demande::find($id);
            $organisation=$demandes->organisation_code;
            $cefore=DB::table('organisations')->where('CodeOrganisation', $organisation)->first();
            $etat=$request->etat;
            $motif=$request->motif;
            $usager_id=$demandes->usager_id;
            $usager=Usager::where('id', $usager_id)->first();
            $user_id=$usager['user_id'];
            $user=User::where('id', $user_id)->first();
            $email=$user->email;
            $details['email'] = $email;
            $details['cefore'] = $cefore->Ville;
            $details['nom'] = $usager->NomRaisonSociale;
            $details['prenom'] =$usager->Prenom;
            $details['nom_commercial'] =$demandes->commercial_name;
            $details['motif'] =$motif;
            $date=new \DateTime();
            $date_validation= $date->format("d-m-Y H:i:s");
            if($etat=="oui"){                
                $demandes->update([
                    'etat'=>1,
                    'Date_etat_validation'=>$date_validation,
                    'User_ayant_valide'=>Auth::user()->id
                   ]);
                  //Mail::to($email)->send(new NotifyValider($details));
                   return redirect()->route('list');
            }
            else{
            
            $demandes->update([
                    'etat'=>2,
                    'motif'=>$motif,
                    'Date_etat_validation'=>$date_validation,
                    'User_ayant_valide'=>Auth::user()->id
                   ]);
            $historique=Historique::create([
                'id_demande'=>$demandes->id,
                'id_user'=>Auth::user()->id,
                'motif'=>$motif
                ]);
//dd($details);
            //Mail::to($email)->send(new NotifyRejet($details));
                   return redirect()->route('list');
            }
        }
        else{
            flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
            return redirect()->back();
        }
        }
        public function liste_filtre(Request $request){
            if (Auth::user()->can('lister.demande'))
            {
            if(Auth::user()->organisation!="001000"){
                $statut=$request->paye;
                $demandes=Demande::where('paye', $statut)->where('organisation_code', Auth::user()->organisation)->get();
                }
            else{
                $statut=$request->paye;
                $demandes=Demande::where('paye', $statut)->get();
                }
            return view('backend.adminlte.liste_demande', compact('demandes'));
        }
        else{
            flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
            return redirect()->back();
        }
        }

        public function update_rejet(Request $request, $id){
            //dd($id);
            $demande=Demande::find($id);
            $demande->update([
                'etat'=>0,             
               ]);

               $historique=Historique::create([
                'id_demande'=>$demande->id,
                'id_user'=>Auth::user()->id,
                'motif'=>"Envoyer Pour Traitement"
                ]);

               return redirect()->back();    
                  
        }
        public function showpj(Piecejointe $piecejointe){
            //dd($piecejointe);
            return view("demande.showPj", compact('piecejointe'));
        }
        public function editpj(Piecejointe $piecejointe){
            return view("demande.editPj", compact('piecejointe'));
        }
        public function updatepj(Piecejointe $piecejointe, Request $request){
            $type_doc=$piecejointe->type_piece;
            $usager= $piecejointe->demande->usager;
            $file = $request->file('piece_jointe_u');
            $extension=$file->getClientOriginalExtension();
            $fileName = $type_doc.'.'.$extension;
            $emplacement='public/files/'.$usager->id;
            $file_url= $request['piece_jointe_u']->storeAs($emplacement, $fileName);
            $url_local=$usager->id.'/'.$fileName;           
            $pj= $piecejointe->update([
                'url'=> $file_url,
                'numero'=> $request->numero_ref,
                'date_etablissement'=> $request->date_detablissment,
                'lieu_etablissement' => $request->lieu_etablissment,
                'url_local'=>$url_local
            ]);
            return redirect()->route("detail.demande", ['id'=>$piecejointe->demande->id]);
        }

        public function statistique(Request $request)
        {
            
            $cefores=DB::table('organisations')->get();
            if($request->datedebut!="")
            {
                //dd($request->datedebut);
                $date_debut=format_date($request->datedebut);
               $demandes=Demande::where('id', 1)->first();
               dd($demandes->created_at);
               
               for($i=0; $i<count($demandes); $i++){           
                    $dates=format_date($demandes[$i]->created_at); 
                    $date=date("Y-m-d", strtotime($dates));
                    dd($date);                    
                }
            
            //dd($date);
               //dd($request->datedebut); 
                           
            }
            if($request->cefore!=""){
                               
                $result=Demande::where('organisation_code',$request->cefore)->get();
                $demandes=$result;
                }
            else{
                if($request->reset=1){
                    $demandes=Demande::all();
                    }
                }
            return view('backend.adminlte.statistique', compact('demandes','cefores'));
        }
        
        public function reponse_paiement(Request $request){
            //dd($request->all());
                $numero_demande=$request->command_number;
                $numero=substr($numero_demande, 0, -5);
                $demande=Demande::where('numero_command', $numero)->first();
                $paiements=Paiement::create([
                    'numero_demande'=>$request->command_number,
                    'statut'=>$request->payment_status,
                    'mode_paiement'=>$request->payment_mode,
                    'paid_sum'=>$request->paid_sum,
                    'paid_amount'=>$request->paid_amount
                ]);
            if($request->payment_status==200){
                
                $date=new \DateTime();
                $date_paiement= $date->format("d-m-Y H:i:s");             
                $demande->update([
                    'paye'=>1,
                    'date_paiement'=>$date_paiement
                   ]);
            }
            else{
                $demande->update([
                    'paye'=>0                    
                   ]);
            }
            return 0;
        }

        public function fnrccm(Request $request)
        {
            $num=$request->numero;
            $requete=Paiement::where('numero_demande',$num)->first();
            
            if($requete){
                $numero=$requete->numero_demande;
                $statut=$requete->statut;
                $mode=$requete->mode_paiement;

                return response()->json([
                    'status'=>$statut,
                    'mode_paiement'=>$mode,
                    'numero'=>$numero
                ]);
            }
            else {
                return response()->json([
                    //'status'=>420,
                    'message'=>'Aucun numero ne correspond a la recherche'                 
                ]);
            }
        }

        public function orange_paiement(Request $request){
            //
           // dd($request->all());
            $customer_msisdn = $request->numero;
            $otp = $request->otp;
            $command=$request->command;
            $montant=$request->montant;
            $token=$request->_token;
            $demande=Demande::find($request->id);

            //dd($token);

            // $client = new \GuzzleHttp\Client([
            //     'verify' => false
            // ]);
            //65909882;
            //Entrep@2;
            //MAISONdelentrerpise;
            // Construction du XML
        $xmlRequest = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
        <COMMAND>
            <TYPE>OMPREQ</TYPE>
            <customer_msisdn>{$customer_msisdn}</customer_msisdn>
            <merchant_msisdn>65909882</merchant_msisdn>
            <api_username>MAISONdelentrerpise</api_username>
            <api_password>Entrep@2</api_password>
            <amount>{$montant}</amount>
            <PROVIDER>101</PROVIDER>
            <PROVIDER2>101</PROVIDER2>
            <PAYID>12</PAYID>
            <PAYID2>12</PAYID2>
            <otp>{$otp}</otp>
            <reference_number>{$token}</reference_number>
            <ext_txn_id>{$command}</ext_txn_id>
        </COMMAND>";

        // Envoi de la requête
        // $url = 'https://apiom.orange.bf:9007/payment'; // Remplacez par l'URL correcte
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/xml',
        // ])->send('POST', $url, [
        //     'body' => $xmlRequest,
        // ]);

         // Initialisation de cURL
         set_time_limit(120);
         $ch = curl_init();

         // Configuration des options cURL
         curl_setopt($ch, CURLOPT_URL, "https://apiom.orange.bf/"); // Remplacez par l'URL correcte
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
         curl_setopt($ch, CURLOPT_HTTPHEADER, [
             'Content-Type: application/xml',
             'Content-Length: ' . strlen($xmlRequest),
         ]);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
 
         // Exécution de la requête
         $response = curl_exec($ch);
         curl_close($ch);

         // Chargement de la réponse XML
         $status = $this->find_between($response, "<status>", "</status>");
         $message = $this->find_between($response, "<message>", "</message>");
         $transID = $this->find_between($response, "<transID>", "</transID>");

         
         $date=new \DateTime();
         $date_paiement= $date->format("d-m-Y H:i:s"); 
         $demande->update([
            'date_initiation'=>$date_paiement
         ]);
         //dd($response);
           // Gestion des erreurs cURL
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            $paiements=Paiement::create([
                'numero_demande'=>$demande->numero_command,
                'statut'=>120,
                'mode_paiement'=>'OrangeMoney',
                'paid_sum'=>$demande->montant_total,
                'message'=>'Erreur dans l\'envoie XML Ou Serveur Orange non disponible !',
                'echec_orange'=>'Oui'              
            ]);
            session()->flash('error', "Paiement Echoué, Veuillez Réessayer !1");
            return redirect()->route('demande.liste');
            //return response()->json(['error' => 'Erreur cURL : ' . $error], 500);
        }
         // Nettoyage de la réponse
        //$response = trim($response); // Supprime les espaces en début et fin
        //$response = preg_replace('/\s+/', ' ', $response); // Réduit les espaces multiples à un seul espace
        // Validation et parsing
         //dd($response);
        //  if($response){
        //     $responseXml = simplexml_load_string($response);
        //     $status = (string)$responseXml->status;
        //     dd($status);
        //  }        

        // Traitement de la réponse XML
        //dd($status);
            try {
                
                if ($status=="200"){
                    if($demande){                        
                        $date=new \DateTime();
                        $date_paiement= $date->format("d-m-Y H:i:s");
                        $demande->update([
                            'paye'=>1,
                            'date_paiement'=>$date_paiement
                        ]);
                        $paiements=Paiement::create([
                            'numero_demande'=>$demande->numero_command,
                            'statut'=>$status,
                            'mode_paiement'=>'OrangeMoney',
                            'paid_sum'=>$demande->montant_total,
                            'message'=>$message,
                            'transId'=>$transID
                        ]);

                    }
                    session()->flash('message', "Paiement Effectué avec succès !");
                    return redirect()->route('demande.liste');
                }
                else{
                    $paiements=Paiement::create([
                        'numero_demande'=>$demande->numero_command,
                        'statut'=>$status,
                        'mode_paiement'=>'OrangeMoney',
                        'paid_sum'=>$demande->montant_total,
                        'message'=>$message,
                        'transId'=>$transID,
                        'echec_orange'=>'Oui'
                    ]);
                    if($status=="990418"){
                    session()->flash('error', "OTP déjà Utilisé, Veuillez Réessayer !!");
                    return redirect()->route('demande.liste');
                    }
                    if($status=="990417"){
                    session()->flash('error', "OTP Incorrect, Veuillez Réessayer !!");
                    return redirect()->route('demande.liste');
                    }
                    if($status=="8"){
                        session()->flash('error', "Le montant à payer doit être " . $montant . " FCFA. Veuillez Réessayer !!");
                        return redirect()->route('demande.liste');
                        }
                    
                    session()->flash('error', "Paiement Echoué, Veuillez Réessayer !!");
                    return redirect()->route('demande.liste');
                }
                
                // $responseXml = simplexml_load_string($response);
                // dd($responseXml);
                // // Vérification du code de statut
                // $status = (string)$responseXml->status;
                // $message = (string)$responseXml->message;
                //dd($status);
            }
            catch (Exception $e) {
                session()->flash('error', "Paiement Echoué, Veuillez Réessayer !!!");
                    return redirect()->route('demande.liste');
                // Gestion des erreurs lors du traitement de la réponse XML
               // return response()->json(['error' => 'Erreur lors du traitement de la réponse XML : ' . $e->getMessage()], 500);
            }

        // Fermeture de la session cURL
        //curl_close($ch);
        session()->flash('error', "Paiement Echoué, Veuillez Réessayer !!!!");
        return redirect()->route('demande.liste');
        
        //return $response;
        }

        public function orange(Request $request){
            //
            //dd($request->all());
            //$command=Demande::where('numero_command', $request->numero_command)->first();
            $id=Demande::where('id', $request->id)->first();
            $command=$id->numero_command;
            $montant=$id->montant_total;
            $montant_telm=$id->montant;
            $demande_id=$id->id;
            return view('orange.index', compact('demande_id', 'command', 'montant','montant_telm'));
        }

    private function find_between($xmlBody, $openTag, $closeTag)
    {
        $openTagpos = strpos($xmlBody, $openTag) + strlen($openTag);
        if (strpos($xmlBody, $openTag) !== false) {
            $closeTagpos = strpos($xmlBody, $closeTag, $openTagpos);
            if (strpos($xmlBody, $closeTag, $openTagpos) !== false) {
                return substr($xmlBody, $openTagpos, $closeTagpos - $openTagpos);
            }
        }
    }

}
