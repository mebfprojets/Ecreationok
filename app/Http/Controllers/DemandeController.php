<?php

namespace App\Http\Controllers;

use App\Exceptions\DemandeRefuseeException;
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
use App\Models\JournalAction;
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
        return view('maintenance');
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
        // Étapes préalables manquantes : on renvoie vers la bonne étape au lieu d'une erreur 500
        if (! $usager) {
            return redirect()->route('create.usager')
                ->with('error', 'Complétez d’abord votre profil de promoteur avant de créer une demande.');
        }
        $demande_pp=Demande::where('usager_id', $usager->id)->where('company_type','EI')->get();
        $nbr_demande_pp=count($demande_pp);
        if($usager!=null){
            $piecejointe_enrs= PieceJointe::where('usager_id',$usager->id)->get();
            if ($piecejointe_enrs->isEmpty()) {
                return redirect()->route('type.entreprise')
                    ->with('error', 'Choisissez d’abord le type d’entreprise et déposez vos pièces jointes avant de remplir la demande.');
            }
            $type_dem = $piecejointe_enrs->first()->type_entreprise;
            $regions= DB::table('regions')->get();
            $pays= DB::table('valeurs')->where('parametre_id',5)->get();
            $fonctions= DB::table('valeurs')->where('parametre_id',8)->get();
            $activites= DB::select('select secteur_activite from activites group by secteur_activite');
            $activites_secondaires= DB::table('activites')->orderby('description','asc')->get(); 
            $FJ_EI= DB::table('forme_juridiques')->where('company_type','EI')->get();
            $FJ_ES= DB::table('forme_juridiques')->where('company_type','ES')->get();
            $FJ_GIE= DB::table('forme_juridiques')->where('company_type','GIE')->get();
            $usage_terrains= DB::table('usage_terrains')->get();
            $all_usagers = collect();
            $civilites=DB::table('valeurs')->where('parametre_id',15)->get();
    
            $prestation_PPs= Prestation::where('type_demande','P1')->get();
            $prestation_PPs= $prestation_PPs->unique('type');
            $prestation_PMs= Prestation::where('type_demande','M1')->get();
            $prestation_PMs= $prestation_PMs->unique('type');      
    
            //dd($type_dem);
            $demandes=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
            $c=count($demandes);
            return view('demande.test' ,compact('piecejointe_enrs','regions', 'pays','fonctions','activites','prestation_PPs','prestation_PMs',
            'FJ_EI','FJ_ES','FJ_GIE','usager','activites_secondaires','pays','all_usagers','usage_terrains','c','nbr_demande_pp','civilites','type_dem'));
        }
        else{
            $c=0;
            return view('demande.test' ,compact('piecejointe_enrs','regions', 'pays','fonctions','activites','prestation_PPs','prestation_PMs',
            'FJ_EI','FJ_ES','FJ_GIE','civilites','usager','activites_secondaires','pays','all_usagers','usage_terrains','c','nbr_demande_pp','type_dem'));
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
        // Champs indispensables au traitement : sans eux, la création échouait en erreur 500.
        $request->validate([
            'type_request' => 'required|in:P1,M1,G1',
            'nom_commercial' => 'required|string|max:255',
            'region_entreprise' => 'required',
            'province_entreprise' => 'required',
            'commune_entreprise' => 'required',
            'secteur_entreprise' => 'required',
            'activite_principale' => 'required',
            'signed' => ['required', 'string', 'regex:/^data:image\/(png|jpe?g);base64,/'],
            'superficie' => 'nullable|integer|min:0|max:999999999',
        ], [
            'superficie.integer' => 'La superficie doit être un nombre entier de m², sans virgule ni point.',
            'superficie.min' => 'La superficie ne peut pas être négative.',
            'superficie.max' => 'La superficie saisie est trop grande.',
            'type_request.required' => 'Le type de demande est manquant. Recommencez la création de la demande depuis le choix du type d’entreprise.',
            'type_request.in' => 'Le type de demande n’est pas reconnu. Recommencez la création de la demande depuis le choix du type d’entreprise.',
            'nom_commercial.required' => 'Le nom commercial est obligatoire.',
            'nom_commercial.max' => 'Le nom commercial est trop long (255 caractères au maximum).',
            'region_entreprise.required' => 'La région de l’entreprise est obligatoire.',
            'province_entreprise.required' => 'La province de l’entreprise est obligatoire.',
            'commune_entreprise.required' => 'La commune de l’entreprise est obligatoire.',
            'secteur_entreprise.required' => 'Le secteur / village de l’entreprise est obligatoire.',
            'activite_principale.required' => 'L’activité principale est obligatoire.',
            'signed.required' => 'La signature est obligatoire : signez dans le cadre prévu avant de valider la demande.',
            'signed.regex' => 'La signature n’a pas été reçue correctement : effacez-la, signez de nouveau puis validez.',
        ]);

        $usager = DB::table('usagers')->where('user_id', Auth::user()->id)->first();
        if (! $usager) {
            return redirect()->route('create.usager')
                ->with('error', 'Complétez d’abord votre profil de promoteur avant de créer une demande.');
        }

        DB::beginTransaction();
        try {
            $reponse = $this->enregistrerDemande($request, $usager);
            DB::commit();

            return $reponse;
        } catch (DemandeRefuseeException $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput($request->except(['signed', '_token']))
                ->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return redirect()->back()
                ->withInput($request->except(['signed', '_token']))
                ->with('error', 'La demande n’a pas pu être enregistrée. Vérifiez les informations saisies puis réessayez ; '
                    .'si le problème persiste, contactez le CEFORE.');
        }
    }

    /**
     * Création de la demande (appelée dans une transaction par store()).
     * Lève DemandeRefuseeException avec un message destiné à l'usager quand une donnée est incohérente.
     */
    private function enregistrerDemande(Request $request, $usager)
    {
        // Contrôle du nom AVANT toute écriture en base (signature, terrain, demande)
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
            $existante = $nomcom ?: $denom;
            // Même promoteur : c'est en général un double envoi du formulaire -> on affiche ses demandes
            if ($existante->usager_id == $usager->id) {
                return redirect()->route('demande.liste')
                    ->with('error', 'Une entreprise existe déjà avec les mêmes informations.');
            }
            throw new DemandeRefuseeException('Une entreprise existe déjà avec les mêmes informations.');
        }

        // Vérification du montant CPC
        $list_code = [];
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
        if (! isset($montant, $montant_total)) {
            throw new DemandeRefuseeException('Le tarif correspondant à ce type de demande est introuvable. '
                .'Vérifiez le type de demande choisi ou contactez le CEFORE.');
        }

       // $num=$request->type_request.
        //Pour la signature
            //$path = 'C:\wamp64/www/Zip Ecreation/Ecreation_sanou/storage/app/public/files/Signature/';
            $path=storage_path('app/public/files/'.$usager->id.'/');
            if(!is_dir($path)){
                mkdir($path, 0755, true);
            }
         //$request->signed->store('public','upload');
        // $path = Storage::putFile('photos', new File('public/upload/'));
        // $path = $request->file('signed')->store('upload', 'public');
         // La signature doit être une vraie image PNG ou JPEG : l'extension du fichier ne doit jamais venir du navigateur
         // (sinon « data:image/php;base64,... » créerait un fichier signature.php).
         if (!preg_match('#^data:image/(png|jpe?g);base64,([A-Za-z0-9+/=\s]+)$#', (string) $request->signed, $signature)) {
             throw new DemandeRefuseeException('La signature n’a pas été reçue correctement. Signez à nouveau dans le cadre prévu, puis réessayez.');
         }
         $image_base64 = base64_decode($signature[2], true);
         $infosImage = $image_base64 === false ? false : @getimagesizefromstring($image_base64);
         if (!$infosImage || !in_array($infosImage[2], [IMAGETYPE_PNG, IMAGETYPE_JPEG], true)) {
             throw new DemandeRefuseeException('La signature n’a pas été reçue correctement. Signez à nouveau dans le cadre prévu, puis réessayez.');
         }
         $image_type = $infosImage[2] === IMAGETYPE_PNG ? 'png' : 'jpeg';
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
        if($request->province_entreprise==6 || $request->province_entreprise==19){
            $Cefore_code='CEFORE TNK';
        }
        elseif($request->province_entreprise==4 || $request->province_entreprise==9){
            $Cefore_code='CEFORE OUA';
        }
        else{
            if (! $Cefore) {
                throw new DemandeRefuseeException('Aucun CEFORE n’est rattaché à la région choisie pour l’entreprise. '
                    .'Vérifiez la région ou contactez le CEFORE.');
            }
            $Cefore_code=$Cefore->CodeOrganisation;
        }
        //$Cefore_code=$Cefore->CodeOrganisation;
        
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
        if (! $activites) {
            throw new DemandeRefuseeException('L’activité principale choisie n’est pas reconnue. Sélectionnez-la de nouveau dans la liste.');
        }
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
        if (! $secteur_village) {
            throw new DemandeRefuseeException('Le secteur / village choisi pour l’entreprise n’est pas reconnu. Sélectionnez-le de nouveau dans la liste.');
        }
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

        {

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
                // (array) : aucun associé / commissaire saisi -> liste vide au lieu d'une erreur 500 (count(null) en PHP 8)
                $associes=array_values((array) $request->associes);
                $fonction_associes=array_values((array) $request->fonction_associes);
                $capital_associes=array_values((array) $request->capital_associes);
                $commissaire=array_values((array) $request->commissaire);
                $qualite_commissaire=array_values((array) $request->qualite_commissaire);
                for($i=0; $i<count($associes); $i++){
                    if(($associes[$i] ?? '')!="" && ($fonction_associes[$i] ?? '')!="" && ($capital_associes[$i] ?? '')!=""){
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
                    if(($commissaire[$i] ?? '')!="" && ($qualite_commissaire[$i] ?? '')!="")
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
// public function updatepj_correct(Request $request){
//     $usager= Usager::where('user_id',Auth::user()->id)->first();
//     if ($request->hasFile('piece_jointe')) {
//         $piecejointe= PieceJointe::find($request->piece_id_correct);
//         $file = $request->file('piece_jointe');
//         $extension=$file->getClientOriginalExtension();
//         $fileName = $piecejointe->type_piece.'.'.$extension;
//         $emplacement='public/files/'.$usager->id;
//         $file_url= $request['piece_jointe']->storeAs($emplacement, $fileName);
//         $url_local=$usager->id.'/'.$fileName;
//         $pj= $piecejointe->update([
//             'url'=> $file_url,
//             'numero'=> $request->numero_ref,
//             'date_etablissement'=> $request->date_detablissment,
//             'lieu_etablissement' => $request->lieu_etablissment,
//             'url_local'=>$url_local
//            // 'categorie_piece'=> $request->categorie_piece
//         ]);
    
//     }
//     if ($pj) {
//        // $data_json= array('data'=>'success','status'=>'201', 'type_doc'=>$type_doc);
//         return redirect()->back();
//     }
    
// }

public function updatepj_correct(Request $request){
    $request->validate([
        'piece_id_correct' => 'required|integer',
        'piece_jointe'     => 'required|'.self::REGLE_FICHIER,
        'numero_ref'       => 'nullable|string|max:255',
    ], array_merge($this->messagesFichier('piece_jointe'), [
        'piece_id_correct.required' => 'La pièce à corriger n’a pas été identifiée. Fermez la fenêtre puis réessayez.',
        'piece_id_correct.integer' => 'La pièce à corriger n’a pas été identifiée. Fermez la fenêtre puis réessayez.',
        'numero_ref.max' => 'Le numéro de référence est trop long.',
    ]));

    $usager = Usager::where('user_id', Auth::user()->id)->firstOrFail();
    $piecejointe = PieceJointe::findOrFail($request->piece_id_correct);

    // La pièce doit appartenir à une demande du promoteur connecté
    if (!$piecejointe->demande || $piecejointe->demande->usager_id != $usager->id) {
        abort(403);
    }
    // Une pièce ne peut être remplacée que si la demande a été rejetée par le CEFORE
    if (! $piecejointe->demande->estRejetee()) {
        return redirect()->back()->with('error', 'Cette pièce ne peut pas être modifiée : seule une demande rejetée par le CEFORE peut être corrigée.');
    }

    $file = $request->file('piece_jointe');
    $extension = strtolower($file->extension());
    $fileName = $piecejointe->type_piece.'.'.$extension;
    $emplacement = 'public/files/'.$usager->id;
    $file_url = $file->storeAs($emplacement, $fileName);
    $url_local = $usager->id.'/'.$fileName;

    $piecejointe->update([
        'url' => $file_url,
        'numero' => $request->numero_ref,
        'date_etablissement' => $request->date_detablissment,
        'lieu_etablissement' => $request->lieu_etablissment,
        'url_local' => $url_local,
    ]);

    return redirect()->back()->with('success', 'La pièce « '.str_replace('_', ' ', $piecejointe->type_piece).' » a été remplacée. '
        .'Une fois toutes les corrections faites, renvoyez la demande pour traitement.');
}

    /**
     * Disponibilité d'un nom commercial auprès du Fichier national RCCM.
     * Les identifiants de l'API sont dans le fichier .env (config/services.php, clé « fnrccm »), jamais dans le code.
     */
    public function verifier_nom_commercial(Request $request){
        $request->validate(['nom_commercial' => 'required|string|max:255'], [
            'nom_commercial.required' => 'Saisissez le nom commercial à vérifier.',
            'nom_commercial.max' => 'Le nom commercial est trop long.',
        ]);
        $indisponible = response()->json([
            'message' => 'La vérification du nom commercial est momentanément indisponible. Réessayez dans quelques instants.',
        ], 503);

        $fnrccm = config('services.fnrccm');
        if (empty($fnrccm['utilisateur']) || empty($fnrccm['mot_de_passe'])) {
            report(new \RuntimeException('Identifiants de l’API FNRCCM absents : renseigner FNRCCM_UTILISATEUR et FNRCCM_MOT_DE_PASSE dans le fichier .env.'));
            return $indisponible;
        }

        try {
            $client = new \GuzzleHttp\Client([
                'base_uri' => rtrim($fnrccm['url'], '/').'/',
                'verify' => $fnrccm['verifier_ssl'],
                'timeout' => 20,
                'headers' => ['Accept' => 'application/json'],
            ]);
            $authentification = json_decode($client->post('api/auth/token', [
                'auth' => [$fnrccm['utilisateur'], $fnrccm['mot_de_passe']],
            ])->getBody()->getContents(), true);
            $jeton = $authentification['response'] ?? null;
            if (!$jeton) {
                throw new \RuntimeException('API FNRCCM : jeton d’accès non reçu.');
            }

            $resultat = json_decode($client->post('api/registres/verifync', [
                'headers' => ['Authorization' => 'Bearer '.$jeton],
                'form_params' => ['keywords' => $request->nom_commercial],
            ])->getBody()->getContents(), true);
        } catch (\Throwable $e) {
            report($e);
            return $indisponible;
        }

        return response()->json([
            'data' => $resultat['response'] ?? null,
            'status' => $resultat['status'] ?? null,
        ]);
    }

public function laodpiecejointe(Request $request){
    $request->validate(['piece_jointe_1' => 'nullable|'.self::REGLE_FICHIER], $this->messagesFichier('piece_jointe_1'));
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
        $request->validate(['piece_jointe_u' => 'nullable|'.self::REGLE_FICHIER], $this->messagesFichier('piece_jointe_u'));
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
            $this->autoriserUsager($piecejointe->usager_id);
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
        $this->autoriserDemande(Demande::find($piecejointe->demande_id));
        //->first();
         // return Response::make(file_get_contents($piecejointe->url), 200, [
         //     'Content-Type' => 'application/pdf',
         //     'Content-Disposition' => 'inline; filename="' . $filename . '"'
         // ]);
        return $path = Storage::download($piecejointe->url);
        
     }

    public function detaildocument_affiche($id){
        $piecejointe= PieceJointe::find($id);
        $this->autoriserUsager($piecejointe->usager_id);
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
            if (! $usager) {
                // Compte sans profil promoteur : aucune demande possible pour l'instant
                $demandes = collect();
                $c = 0;
                return view('demande.liste', compact('demandes','c'));
            }
            $demandes=Demande::where('usager_id', $usager->id)->orderby('created_at','desc')->get();
            $c=count($demandes);
            return view('demande.liste', compact('demandes','c'));
        }

        public function detail($id)
        {
            
            
            $demandes=Demande::where('id', $id)->first();
            $this->autoriserDemande($demandes);
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
            $cefore_code=$cefore ? $cefore->Ville : $demandes->organisation_code;
            $types_formalites=Valeur::where('parametre_id',18)->orderby('libelle','desc')->get();
            // Adresse propre du dirigeant (et non celle de l'entreprise)
            $commune_usager=DB::table('commune_departements')->where('id', $usager->Commun_Departement_Code)->first();
            // Rejets et renvois pour traitement
            $historiques=$demandes->historiques()->get();
            return view('demande.detailtest', compact('demandes','usager','activites','forme_juridiques',
            'professions','regions','provinces','communes','arrondissements','secteurs','terrains','piecejointes',
        'secteur_usager','province_usager','region_usager','c','cefore_code','regions_all','FJ_EI','FJ_ES','FJ_GIE',
    'activites_all','usage_terrains','civilites','professions','nationalites','pays','types_formalites',
    'commune_usager','historiques'));
  
        
        }

        // public function valider_paiement (Request $request)
        // {
        //     //dd($request->all());
        //     $date=new \DateTime();
        //     //$id=$request->id;
        //     $date_initiation= $date->format("d-m-Y H:i:s");
        //     $numero_demande=$request->num_command;
        //     $numero=substr($numero_demande, 0, -5);
        //     //dd($numero);    
        //    $demande=Demande::where('numero_command',$numero)->first();
        //    $usager=Usager::where('id',$demande->usager_id)->first();
        //    if($demande->date_initiation==null){
        //     $demande->update([               
        //         'date_initiation'=>$date_initiation
        //         ]);
        //    }
        //    if($demande->paye!="1"){
        //    $demande->update([
        //     'paye'=>2            
        //     ]);
        //     }           
        //     return redirect()->route('demande.liste');
        // }
        public function facture($id)
        {
            $demande=Demande::where('id', $id)->first();
            $this->autoriserDemande($demande); 
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
            $this->autoriserDemande($demande);
            // Un promoteur ne peut corriger sa demande que lorsqu'elle a été rejetée (les agents, toujours)
            if (Auth::user()->isadmin == null && ! $demande->estRejetee()) {
                return redirect()->back()->with('error', 'Cette demande ne peut pas être modifiée : seule une demande rejetée par le CEFORE peut être corrigée.');
            }
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
            else{
                $forme_juridique=$demande->forme_juridique;
            }
            $demande->forme_juridique=$forme_juridique;
            $demande->activity_sector=$request->secteur_activite ?: $demande->activity_sector;
            $demande->primary_activity=$request->activite_principale ?: $demande->primary_activity;
            //$demande->region_code=$request->region_entreprise;
            //Mise à jour du terrain
            $terrain=Terrain::find($request->id_terrain ?: $demande->id_terrain);
            if ($terrain) {
                $terrain->numero_lot=$request->lot;
                $terrain->numero_section=$request->section;
                $terrain->numero_parcelle=$request->parcelle;
                $terrain->id_usage_terrain=$request->usage;
                $terrain->update();
            }

            $demande->update();
            JournalAction::noter('demande_corrigee', $demande);
            return redirect()->back()->with('success', $demande->estRejetee()
                ? 'Les informations de l’entreprise ont été corrigées. Une fois toutes les corrections faites, renvoyez la demande pour traitement.'
                : 'Les informations de l’entreprise ont été mises à jour.');
           
        }

        public function update_usager(Request $request, $id)
        {//
            //dd($request->province_usager);
            $usager=Usager::find($id);   
            $this->autoriserUsager($usager->id);                      
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
            // La page détail côté agents indique la demande consultée
            $demandeConcernee = Demande::where('id', (int) $request->demande)->where('usager_id', $usager->id)->first();
            JournalAction::noter('dirigeant_corrige', $demandeConcernee);
            return redirect()->back()->with('success', 'Les informations du dirigeant ont été mises à jour.');
        }

        /** Demandes visibles par l'agent connecté : celles de son CEFORE (le siège voit tout). */
        private function demandesVisibles()
        {
            $requete = Demande::query();
            if (!$this->estAgentSiege(Auth::user())) {
                $requete->where('organisation_code', Auth::user()->organisation);
            }
            return $requete;
        }

        /** Compteurs des cases du tableau de bord, calculés en base (COUNT) et non en chargeant les demandes. */
        private function compteursDemandes(): array
        {
            return [
                'nbr' => $this->demandesVisibles()->whereNotNull('etat')->count(),
                'nbr_paye' => $this->demandesVisibles()->where('paye', 1)->count(),
                'nbr_nonpaye' => $this->demandesVisibles()->where('paye', 0)->count(),
                'nbr_rejet' => $this->demandesVisibles()->where('etat', 2)->count(),
                'nbr_a_valider' => $this->demandesVisibles()->where('paye', 1)->where('etat', 0)->count(),
                'nbr_validees' => $this->demandesVisibles()->where('etat', 1)->count(),
            ];
        }

        public function index_admin(){
            if (!Auth::user()->can('lister.demande')) {
                return $this->refuserAcces();
            }
            // Les 50 dernières actions des agents (validations, rejets, corrections...), limitées au CEFORE de l'agent
            $actions = JournalAction::with([
                    'agent:id,name,prenom,organisation',
                    'demande:id,numero_demande,commercial_name,denomination_social,organisation_code',
                ])
                ->when(!$this->estAgentSiege(Auth::user()), function ($q) {
                    $organisation = Auth::user()->organisation;
                    $q->where(function ($w) use ($organisation) {
                        $w->whereHas('demande', fn ($d) => $d->where('organisation_code', $organisation))
                          ->orWhere(fn ($x) => $x->whereNull('demande_id')->where('organisation', $organisation));
                    });
                })
                ->orderBy('created_at', 'desc')->orderBy('id', 'desc')
                ->take(50)
                ->get();
            $siege = $this->estAgentSiege(Auth::user());

            return view('backend.adminlte.dashboard', array_merge($this->compteursDemandes(), compact('actions', 'siege')));
        }

        public function all(){
            if (!Auth::user()->can('lister.demande')) {
                return $this->refuserAcces();
            }
            // Le tableau est rempli page par page par all_donnees() : plus de chargement de toutes les demandes d'un coup
            return view('backend.adminlte.all', $this->compteursDemandes());
        }

        /** Données de « Toutes les demandes » au format attendu par DataTables (traitement côté serveur). */
        public function all_donnees(Request $request)
        {
            if (!Auth::user()->can('lister.demande')) {
                abort(403);
            }
            $colonnes = [0 => 'numero_demande', 1 => 'legal_rep_name', 2 => 'paye', 3 => 'commercial_name', 4 => 'denomination_social',
                5 => 'sigle', 7 => 'created_at', 8 => 'primary_activity', 10 => 'organisation_code', 11 => 'date_paiement'];

            $base = $this->demandesVisibles()->whereNotNull('etat');
            $total = (clone $base)->count();

            $recherche = trim((string) data_get($request->input('search'), 'value', ''));
            if ($recherche !== '') {
                $motif = '%'.str_replace(['[', '%', '_'], ['[[]', '[%]', '[_]'], $recherche).'%';
                $base->where(function ($q) use ($motif) {
                    foreach (['numero_demande', 'legal_rep_name', 'commercial_name', 'denomination_social', 'sigle', 'primary_activity', 'organisation_code'] as $champ) {
                        $q->orWhere($champ, 'like', $motif);
                    }
                });
            }
            $filtre = (clone $base)->count();

            $tri = $colonnes[(int) data_get($request->input('order'), '0.column', 7)] ?? 'created_at';
            $sens = data_get($request->input('order'), '0.dir') === 'asc' ? 'asc' : 'desc';
            $longueur = max(1, min(100, (int) $request->input('length', 25)));
            $debut = max(0, (int) $request->input('start', 0));

            $lignes = $base->orderBy($tri, $sens)->orderBy('id', 'desc')->skip($debut)->take($longueur)
                ->get(['id', 'numero_demande', 'legal_rep_name', 'paye', 'commercial_name', 'denomination_social', 'sigle',
                    'created_at', 'primary_activity', 'objet_social', 'organisation_code', 'date_paiement'])
                ->map(function ($d) {
                    $date = fn ($v) => $v ? date('d-m-Y', strtotime($v)) : '—';
                    return [
                        e($d->numero_demande),
                        e($d->legal_rep_name),
                        $d->paye == 1 ? 'Payé' : ($d->paye == 2 ? 'Paiement à confirmer' : 'Non payé'),
                        e($d->commercial_name),
                        e($d->denomination_social),
                        e($d->sigle),
                        '<a href="'.e(route('detail.demande', $d->id)).'" class="btn btn-sm btn-primary" title="Afficher le détail"><i class="fa fa-eye" aria-hidden="true"></i><span class="visually-hidden">Détail</span></a>',
                        $date($d->created_at),
                        e($d->primary_activity),
                        e(\Illuminate\Support\Str::limit((string) $d->objet_social, 80)),
                        e($d->organisation_code),
                        $date($d->date_paiement),
                    ];
                });

            return response()->json([
                'draw' => (int) $request->input('draw'),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtre,
                'data' => $lignes,
            ]);
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
            // Compteurs calculés en base et limités au CEFORE de l'agent (le siège voit tout)
            $demandes=$this->demandesVisibles()->whereNotNull('RCCM')->orderBy('created_at','desc')->get();
            $rccm=$this->demandesVisibles()->whereNull('RCCM')->where('etat', 1)->count();
            $ifu=$this->demandesVisibles()->whereNull('IFU')->where('etat', 1)->count();
            $cnss=$this->demandesVisibles()->whereNull('CNSS')->where('etat', 1)->count();
            $cpc=$this->demandesVisibles()->whereNull('CPC')->where('etat', 1)->count();
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

        /** Page de traitement d'une demande par un agent (informations, pièces, historique, décision). */
        public function detail_backend($id)
        {
            if (!Auth::user()->can('lister.demande')) {
                return $this->refuserAcces();
            }
            $demandes = Demande::where('id', $id)->first();
            $this->autoriserAgentDemande($demandes);
            $usager = Usager::where('id', $demandes->usager_id)->first();
            $compte = $usager ? User::find($usager->user_id, ['id', 'name', 'prenom', 'email']) : null;

            // Référentiels (affichage et formulaires de correction)
            $activites = DB::table('activites')->where('Code', $demandes->primary_activity)->first();
            $forme_juridiques = DB::table('forme_juridiques')->where('code', $demandes->forme_juridique)->first();
            $regions = DB::table('regions')->where('id', $demandes->region_code)->first();
            $provinces = DB::table('provinces')->where('id', $demandes->province_code)->first();
            $communes = DB::table('commune_departements')->where('id', $demandes->commune_departement_code)->first();
            $arrondissements = DB::table('arrondissements')->where('id', $demandes->arrondissement_code)->first();
            $secteurs = DB::table('secteur_villages')->where('code', $demandes->code_secteur_village)->first();
            $terrains = DB::table('terrains')->where('id', $demandes->id_terrain)->first();
            $region_usager = DB::table('regions')->where('id', $usager->Region_Code)->first();
            $province_usager = DB::table('provinces')->where('id', $usager->Province_Code)->first();
            $commune_usager = DB::table('commune_departements')->where('id', $usager->Commun_Departement_Code)->first();
            $arrondissement_usager = DB::table('arrondissements')->where('id', $usager->Arrondissement_Code)->first();
            $secteur_usager = DB::table('secteur_villages')->where('code', $usager->Code_Secteur_Village)->first();
            $nationalites = DB::table('valeurs')->where('parametre_id', 6)->orderBy('libelle', 'asc')->get();
            $civilites = DB::table('valeurs')->where('parametre_id', 15)->get();
            $pays = DB::table('valeurs')->where('parametre_id', 5)->orderBy('libelle', 'asc')->get();
            $professions = DB::table('valeurs')->where('parametre_id', 8)->orderBy('libelle', 'asc')->get();
            $FJ_EI = DB::table('forme_juridiques')->where('company_type', 'EI')->get();
            $FJ_ES = DB::table('forme_juridiques')->where('company_type', 'ES')->get();
            $FJ_GIE = DB::table('forme_juridiques')->where('company_type', 'GIE')->get();
            $activites_all = DB::select('select secteur_activite from activites group by secteur_activite');
            $usage_terrains = DB::table('usage_terrains')->get();
            $typepieceformaliteretours = Valeur::where('parametre_id', 18)->get();
            $cefore = DB::table('organisations')->where('CodeOrganisation', $demandes->organisation_code)->first();
            $cefore_code = $cefore->Ville ?? $demandes->organisation_code;

            $piecejointes = PieceJointe::where('demande_id', $demandes->id)->orderBy('id')->get()
                ->each(fn ($piece) => $piece->fichier_present = $this->localiserFichier($piece->url) !== null);
            $premierePiece = $piecejointes->firstWhere('fichier_present', true);
            $autresDemandes = Demande::where('usager_id', $usager->id)->where('id', '!=', $demandes->id)
                ->orderBy('created_at', 'desc')->get(['id', 'numero_demande', 'commercial_name', 'denomination_social', 'etat', 'paye', 'created_at']);
            $validateur = $demandes->User_ayant_valide ? User::find($demandes->User_ayant_valide, ['id', 'name', 'prenom']) : null;

            // Historique du dossier : création, paiement, actions des agents (journal), renvois du promoteur
            $historique = collect([['date' => $demandes->created_at, 'type' => 'creation', 'titre' => 'Demande créée par le promoteur', 'detail' => null, 'auteur' => null]]);
            if ($demandes->paye == 1 && $demandes->date_paiement) {
                $historique->push(['date' => \Carbon\Carbon::parse($demandes->date_paiement), 'type' => 'paiement',
                    'titre' => 'Paiement reçu'.($demandes->montant_total ? ' ('.number_format((float) $demandes->montant_total, 0, ',', ' ').' FCFA)' : ''), 'detail' => null, 'auteur' => null]);
            }
            foreach (JournalAction::with('agent:id,name,prenom')->where('demande_id', $demandes->id)->get() as $action) {
                $historique->push(['date' => $action->created_at, 'type' => $action->action, 'titre' => $action->libelle(),
                    'detail' => $action->detail, 'auteur' => $action->agent ? trim($action->agent->prenom.' '.$action->agent->name) : null]);
            }
            foreach (Historique::where('id_demande', $demandes->id)->where('motif', 'Envoyer Pour Traitement')->get() as $renvoi) {
                $historique->push(['date' => $renvoi->created_at, 'type' => 'renvoi', 'titre' => 'Corrigée et renvoyée par le promoteur', 'detail' => null, 'auteur' => null]);
            }
            $historique = $historique->filter(fn ($e) => $e['date'])->sortByDesc(fn ($e) => $e['date']->timestamp)->values();

            // Statut lisible et possibilité de décider
            $renvoyee = $historique->first(fn ($e) => in_array($e['type'], ['rejet', 'renvoi'], true));
            $statut = match (true) {
                (int) $demandes->paye === 0 => ['En attente de paiement', 'secondary', 'fa-credit-card'],
                (int) $demandes->paye === 2 => ['Paiement à confirmer', 'info', 'fa-hourglass-start'],
                (string) $demandes->etat === '1' => ['Validée', 'success', 'fa-check-circle'],
                (string) $demandes->etat === '2' => ['Rejetée — en attente de correction', 'danger', 'fa-undo-alt'],
                ($renvoyee['type'] ?? null) === 'renvoi' => ['À valider — corrigée par le promoteur', 'warning', 'fa-redo-alt'],
                default => ['À valider', 'warning', 'fa-hourglass-half'],
            };
            $peutTraiter = Auth::user()->can('valider.demande') && (int) $demandes->paye === 1 && (string) $demandes->etat === '0';
            $peutCorriger = Auth::user()->can('valider.demande') && (int) $demandes->paye === 1 && (string) $demandes->etat === '2';

            return view('backend.adminlte.detail', compact(
                'demandes', 'usager', 'compte', 'activites', 'forme_juridiques', 'regions', 'provinces', 'communes', 'arrondissements',
                'secteurs', 'terrains', 'region_usager', 'province_usager', 'commune_usager', 'arrondissement_usager', 'secteur_usager',
                'nationalites', 'civilites', 'pays', 'professions', 'FJ_EI', 'FJ_ES', 'FJ_GIE', 'activites_all', 'usage_terrains',
                'typepieceformaliteretours', 'cefore_code', 'piecejointes', 'premierePiece', 'autresDemandes', 'validateur', 'historique', 'statut',
                'peutTraiter', 'peutCorriger'
            ));
        }

    public function add_formalite_retour(Request $request){
        return $this->enregistrerFormaliteRetour($request);
    }

    public function update_formalite_retour(Request $request){
        return $this->enregistrerFormaliteRetour($request);
    }

    /** Ajout ou remplacement de la copie d'une formalité de retour (RCCM, IFU...) par un agent du CEFORE de la demande. */
    private function enregistrerFormaliteRetour(Request $request)
    {
        if (!Auth::user()->can('save_formalite_retour')) {
            return $this->refuserAcces();
        }
        $request->validate([
            'demande' => 'required|integer',
            'typepiece' => 'required|integer',
            'copie_de_la_formalite' => 'required|'.self::REGLE_FICHIER,
        ], array_merge($this->messagesFichier('copie_de_la_formalite'), [
            'demande.*' => 'La demande n’a pas été identifiée. Rechargez la page puis réessayez.',
            'typepiece.*' => 'Le type de formalité n’a pas été identifié. Fermez la fenêtre puis réessayez.',
        ]));

        $demande = Demande::find($request->demande);
        $this->autoriserAgentDemande($demande);

        $file = $request->file('copie_de_la_formalite');
        $fileName = getlibelle($request->typepiece).'.'.strtolower($file->extension());
        $file_url = $file->storeAs('public/files/formalite_retours/'.$demande->id, $fileName);

        Formalite::updateOrCreate(
            ['demande_id' => $demande->id, 'typepiece' => $request->typepiece],
            ['url' => $file_url]
        );
        flash('La copie de la formalité a été enregistrée.')->success();

        return redirect()->back();
    }

public function show_formalite_retour(Formalite $formalite){
    if (!Auth::user()->can('lister.demande')) {
        return $this->refuserAcces();
    }
    $this->autoriserAgentDemande(Demande::find($formalite->demande_id));

    return view("demande.detailformalite", compact('formalite'));
}

    /** Affichage d'une pièce jointe (dans la page) : promoteur propriétaire ou agent du CEFORE de la demande. */
    public function voirPiece($id)
    {
        $piecejointe = PieceJointe::find($id);
        if (!$piecejointe) {
            abort(404);
        }
        if ($piecejointe->demande_id) {
            $this->autoriserDemande(Demande::find($piecejointe->demande_id));
        } else {
            $this->autoriserUsager($piecejointe->usager_id);
        }

        return $this->afficherFichier($piecejointe->url);
    }

    /** Affichage de la copie d'une formalité de retour : promoteur propriétaire ou agent du CEFORE de la demande. */
    public function voirFormalite($id)
    {
        $formalite = Formalite::find($id);
        if (!$formalite) {
            abort(404);
        }
        $this->autoriserDemande(Demande::find($formalite->demande_id));

        return $this->afficherFichier($formalite->url);
    }

    private function afficherFichier(?string $chemin)
    {
        $entetes = ['Cache-Control' => 'private, no-store', 'X-Content-Type-Options' => 'nosniff'];
        $fichier = $this->localiserFichier($chemin);
        if ($fichier === null) {
            abort(404, 'Le fichier est introuvable.');
        }
        if ($fichier['absolu']) {
            return response()->file($fichier['chemin'], $entetes)->setPrivate();
        }

        return Storage::response($fichier['chemin'], basename($fichier['chemin']), $entetes);
    }

    /**
     * Retrouve le fichier d'une pièce : chemin relatif au disque local (cas général) ou chemin complet
     * (signatures), accepté seulement s'il se trouve dans storage/app. Renvoie null si le fichier n'existe pas.
     */
    private function localiserFichier(?string $chemin): ?array
    {
        if (!$chemin) {
            return null;
        }
        $complet = realpath($chemin);
        $racine = realpath(storage_path('app'));
        if ($complet && $racine && str_starts_with($complet, $racine.DIRECTORY_SEPARATOR) && is_file($complet)) {
            return ['chemin' => $complet, 'absolu' => true];
        }

        return Storage::exists($chemin) ? ['chemin' => $chemin, 'absolu' => false] : null;
    }

    public function valider_demande(Request $request , $id){
        if (Auth::user()->can('valider.demande'))
            {
            $request->validate([
                'etat' => 'required|in:oui,non',
                'motif' => 'nullable|required_if:etat,non|string|max:2000',
            ], [
                'etat.*' => 'La décision (validation ou rejet) n’a pas été reçue. Rechargez la page puis réessayez.',
                'motif.required_if' => 'Saisissez le motif du rejet : il sera communiqué au promoteur.',
                'motif.max' => 'Le motif du rejet ne doit pas dépasser 2000 caractères.',
            ]);
            $demandes=Demande::find($id);
            $this->autoriserAgentDemande($demandes);
            // Seule une demande payée et en attente de validation peut être validée ou rejetée
            if ((int) $demandes->paye !== 1 || (string) $demandes->etat !== '0') {
                flash('Cette demande n’est pas en attente de validation : elle n’est pas payée ou a déjà été traitée.')->error();
                return redirect()->route('detail.demande', $demandes->id);
            }
            $motif=$request->motif;
            $usager=Usager::find($demandes->usager_id);
            $date_validation=(new \DateTime())->format("d-m-Y H:i:s");

            if($request->etat=="oui"){
                $demandes->update([
                    'etat'=>1,
                    'Date_etat_validation'=>$date_validation,
                    'User_ayant_valide'=>Auth::user()->id
                   ]);
                JournalAction::noter('validation', $demandes);
                $envoye = $this->prevenirPromoteur(new NotifyValider($demandes, $usager), $usager);
                flash('La demande « '.$demandes->commercial_name.' » a été validée.'
                    .($envoye ? ' Le promoteur a été prévenu par e-mail.' : ''))->success();
            }
            else{
                $demandes->update([
                    'etat'=>2,
                    'motif'=>$motif,
                    'Date_etat_validation'=>$date_validation,
                    'User_ayant_valide'=>Auth::user()->id
                   ]);
                Historique::create([
                    'id_demande'=>$demandes->id,
                    'id_user'=>Auth::user()->id,
                    'motif'=>$motif
                    ]);
                JournalAction::noter('rejet', $demandes, $motif);
                $envoye = $this->prevenirPromoteur(new NotifyRejet($demandes, $usager), $usager);
                flash('La demande « '.$demandes->commercial_name.' » a été rejetée et renvoyée au promoteur pour correction.'
                    .($envoye ? ' Le promoteur a été prévenu par e-mail.' : ''))->success();
            }
            if (!$envoye) {
                flash('Le promoteur n’a pas pu être prévenu par e-mail (adresse absente ou service d’envoi indisponible). '
                    .'Il verra la décision dans son espace « Mes demandes » ; vous pouvez aussi le contacter directement.')->warning()->important();
            }
            return redirect()->route('list', ['etat' => 0]);
        }
        else{
            flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
            return redirect()->back();
        }
        }
    /**
     * Envoie au promoteur l'e-mail de décision. La décision est déjà enregistrée : un échec d'envoi
     * ne doit pas l'annuler, il est seulement signalé à l'agent (et écrit dans le journal).
     */
    private function prevenirPromoteur(\Illuminate\Mail\Mailable $mail, ?Usager $usager): bool
    {
        $email = $usager ? User::where('id', $usager->user_id)->value('email') : null;
        if (!$email) {
            return false;
        }
        try {
            Mail::to($email)->send($mail);
            return true;
        } catch (\Throwable $e) {
            report($e);
            return false;
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
            $this->autoriserDemande($demande);
            // Seule une demande rejetée peut être renvoyée pour traitement
            if (! $demande->estRejetee()) {
                return redirect()->back()->with('error', 'Cette demande n’est pas en attente de correction : elle ne peut pas être renvoyée pour traitement.');
            }
            $demande->update([
                'etat'=>0,
               ]);

               $historique=Historique::create([
                'id_demande'=>$demande->id,
                'id_user'=>Auth::user()->id,
                'motif'=>"Envoyer Pour Traitement"
                ]);

               return redirect()->back()->with('success', 'Votre demande a été renvoyée au CEFORE pour traitement. Vous serez informé(e) de la suite.');
                  
        }
        public function showpj(Piecejointe $piecejointe){
            if (!Auth::user()->can('lister.demande')) {
                return $this->refuserAcces();
            }
            $this->autoriserAgentDemande($piecejointe->demande);
            return view("demande.showPj", compact('piecejointe'));
        }
        public function editpj(Piecejointe $piecejointe){
            if (!Auth::user()->can('valider.demande')) {
                return $this->refuserAcces();
            }
            $this->autoriserAgentDemande($piecejointe->demande);
            return view("demande.editPj", compact('piecejointe'));
        }
        public function updatepj(Piecejointe $piecejointe, Request $request){
            if (!Auth::user()->can('valider.demande')) {
                return $this->refuserAcces();
            }
            $this->autoriserAgentDemande($piecejointe->demande);
            $request->validate([
                'piece_jointe_u' => 'nullable|'.self::REGLE_FICHIER,
                'numero_ref' => 'nullable|string|max:255',
            ], array_merge($this->messagesFichier('piece_jointe_u'), [
                'numero_ref.max' => 'Le numéro de référence est trop long.',
            ]));
            $donnees = [
                'numero'=> $request->numero_ref,
                'date_etablissement'=> $request->date_detablissment,
                'lieu_etablissement' => $request->lieu_etablissment,
            ];
            // Le fichier n'est remplacé que si un nouveau fichier a été choisi
            if ($request->hasFile('piece_jointe_u')) {
                $usager = $piecejointe->demande->usager;
                $fileName = $piecejointe->type_piece.'.'.strtolower($request->file('piece_jointe_u')->extension());
                $donnees['url'] = $request->file('piece_jointe_u')->storeAs('public/files/'.$usager->id, $fileName);
                $donnees['url_local'] = $usager->id.'/'.$fileName;
            }
            $piecejointe->update($donnees);
            JournalAction::noter('piece_modifiee', $piecejointe->demande, str_replace('_', ' ', $piecejointe->type_piece));
            flash('La pièce « '.str_replace('_', ' ', $piecejointe->type_piece).' » a été mise à jour.')->success();
            return redirect()->route("detail.demande", ['id'=>$piecejointe->demande->id]);
        }

        /**
         * Statistiques par CEFORE sur une période (date de création des demandes).
         * Tout est compté en base ; un agent ne voit que son CEFORE, le siège peut choisir un CEFORE ou tous.
         */
        public function statistique(Request $request)
        {
            if (!Auth::user()->can('lister.demande')) {
                return $this->refuserAcces();
            }
            $request->validate([
                'du' => 'nullable|date_format:Y-m-d',
                'au' => 'nullable|date_format:Y-m-d|after_or_equal:du',
                'cefore' => 'nullable|string|max:50',
            ], [
                'du.date_format' => 'La date de début n’est pas valide.',
                'au.date_format' => 'La date de fin n’est pas valide.',
                'au.after_or_equal' => 'La date de fin doit être postérieure à la date de début.',
            ]);

            $siege = $this->estAgentSiege(Auth::user());
            $du = $request->input('du', now()->startOfYear()->format('Y-m-d'));
            $au = $request->input('au', now()->format('Y-m-d'));
            $ceforeChoisi = $siege ? $request->input('cefore') : Auth::user()->organisation;

            $requete = Demande::query()->whereNotNull('etat')
                // Format ISO (avec « T ») : interprété de la même façon quelle que soit la langue de SQL Server
                ->where('created_at', '>=', $du.'T00:00:00')
                ->where('created_at', '<', \Carbon\Carbon::parse($au)->addDay()->format('Y-m-d').'T00:00:00');
            if ($ceforeChoisi) {
                $requete->where('organisation_code', $ceforeChoisi);
            }

            $parCefore = $requete->groupBy('organisation_code')->orderBy('organisation_code')->get([
                'organisation_code',
                DB::raw('COUNT(*) AS total'),
                DB::raw('SUM(CASE WHEN paye = 1 THEN 1 ELSE 0 END) AS payees'),
                DB::raw('SUM(CASE WHEN paye = 0 THEN 1 ELSE 0 END) AS non_payees'),
                DB::raw('SUM(CASE WHEN paye = 1 AND etat = 0 THEN 1 ELSE 0 END) AS a_valider'),
                DB::raw('SUM(CASE WHEN etat = 1 THEN 1 ELSE 0 END) AS validees'),
                DB::raw('SUM(CASE WHEN etat = 2 THEN 1 ELSE 0 END) AS rejetees'),
                DB::raw('SUM(CASE WHEN paye = 1 THEN CAST(montant_total AS DECIMAL(18,0)) ELSE 0 END) AS montant'),
            ]);

            $totaux = ['total' => 0, 'payees' => 0, 'non_payees' => 0, 'a_valider' => 0, 'validees' => 0, 'rejetees' => 0, 'montant' => 0];
            foreach ($parCefore as $ligne) {
                foreach ($totaux as $cle => $valeur) {
                    $totaux[$cle] += (float) $ligne->$cle;
                }
            }
            $nomsCefore = DB::table('organisations')->pluck('Ville', 'CodeOrganisation');
            $cefores = $siege ? DB::table('organisations')->orderBy('Ville')->get(['CodeOrganisation', 'Ville']) : collect();

            return view('backend.adminlte.statistique', compact('parCefore', 'totaux', 'nomsCefore', 'cefores', 'siege', 'du', 'au', 'ceforeChoisi'));
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
            $token=$request->_token;
            $demande = Demande::findOrFail($request->id);
            $this->autoriserDemande($demande);
            // Montant fixé par le serveur, jamais par le formulaire (il était modifiable avec F12)
            $montant = (int) $demande->montant_total;

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
            session()->flash('error', "Le paiement n’a pas abouti. Vérifiez vos informations puis réessayez.");
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
                    session()->flash('message', "Paiement effectué avec succès. Votre demande est transmise au CEFORE pour traitement.");
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
                    session()->flash('error', "Ce code OTP a déjà été utilisé. Générez un nouveau code puis réessayez.");
                    return redirect()->route('demande.liste');
                    }
                    if($status=="990417"){
                    session()->flash('error', "Le code OTP est incorrect. Vérifiez-le puis réessayez.");
                    return redirect()->route('demande.liste');
                    }
                    if($status=="8"){
                        session()->flash('error', "Le montant payé ne correspond pas : il doit être de " . $montant . " FCFA. Veuillez réessayer.");
                        return redirect()->route('demande.liste');
                        }
                    
                    session()->flash('error', "Le paiement n’a pas abouti. Vérifiez vos informations puis réessayez.");
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
                session()->flash('error', "Le paiement n’a pas abouti. Vérifiez vos informations puis réessayez.");
                    return redirect()->route('demande.liste');
                // Gestion des erreurs lors du traitement de la réponse XML
               // return response()->json(['error' => 'Erreur lors du traitement de la réponse XML : ' . $e->getMessage()], 500);
            }

        // Fermeture de la session cURL
        //curl_close($ch);
        session()->flash('error', "Le paiement n’a pas abouti. Vérifiez vos informations puis réessayez.");
        return redirect()->route('demande.liste');
        
        //return $response;
        }

        public function orange(Request $request){
            //
            //dd($request->all());
            //$command=Demande::where('numero_command', $request->numero_command)->first();
            $id=Demande::where('id', $request->id)->first();
            $this->autoriserDemande($id);
            if ($id->paye != 0) {
                return redirect()->route('demande.liste')->with('message', 'Cette demande est déjà payée ou son paiement est en cours de vérification.');
            }
            $command=$id->numero_command;
            $montant=$id->montant_total;
            $montant_telm=$id->montant;
            $demande_id=$id->id;
            $demande=$id;
            return view('orange.index', compact('demande_id', 'command', 'montant','montant_telm','demande'));
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

    public function moov(Request $request){
        //
        //dd($request->all());
        //$command=Demande::where('numero_command', $request->numero_command)->first();
        $id=Demande::where('id', $request->id)->first();
        $this->autoriserDemande($id);
        if ($id->paye != 0) {
            return redirect()->route('demande.liste')->with('message', 'Cette demande est déjà payée ou son paiement est en cours de vérification.');
        }
        $command=$id->numero_command;
        $montant=$id->montant_total;
        $otp=0;
        $demande_id=$id->id;
        $demande=$id;
        return view('moov.index', compact('demande_id', 'command', 'montant','otp','demande'));
    }

    public function moov_store(Request $request){
        //
        // Préparation des données
        //dd($request->all());
        $id=Demande::where('id', $request->id)->first();
        $chaine = Str::random(10);
        $command=$id->numero_command;
        $num_command=$command."-".$chaine;
        $demande_id=$id->id;
        $montant= (int) $id->montant_total;
        $numero=$request->numero;
        //dd($montant);
        $data = [
            "request-id"    => $num_command,
            "destination"   => $numero,
            "amount"        => $montant,
            "remarks"       => "OTP TEST",
            "message"       => "GENERATION OTP MOOV",                    
            "extended-data"=>[
                    "module"=> "MERCHOTPPAY"
                ]
               
                //  new \stdClass()
                // 
                // "request-id" =>"Test-LLNew-API-FF-hhl-KKKhkkh",
                // "destination"=> "22660484705",
                // "amount"=> 100,
                // "remarks"=> "OTP Merchaant",
                // "extended-data"=>[
                //     "module"=> "MERCHOTPPAY"
                // ]
            ];
            //dd($data);
            $curl = curl_init();
            //$acces= base64_encode("MAISON:OjX8eJ9rlCC4"); //Acces de test
            $acces = base64_encode(env('USER_API_MOOV') . ':' . env('MDP_API_MOOV')); //Acces de Prod
            $url_prod="https://196.28.245.227/tlcfzc_gw_prod/mbs-gateway/gateway/3pp/transaction/process";
            $url_test="https://196.28.245.227/tlcfzc_gw/api/gateway/3pp/transaction/process";

            //https://196.28.245.227/tlcfzc_gw_prod/mbs-gateway/gateway/3pp/transaction/process
            //https://196.28.245.227/tlcfzc_gw/api/gateway/3pp/transaction/process
            curl_setopt_array($curl, [
                CURLOPT_URL            => env('URL_API_MOOV'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => "UTF-8",
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_CUSTOMREQUEST  => "POST",
                CURLOPT_POSTFIELDS     => json_encode($data),
                CURLOPT_HTTPHEADER     => [
                    "Authorization: Basic ".$acces, // À remplacer par vos credentials
                    "Content-Type: application/json",
                    "Accept: */*",
                   //"command-id: mror-transaction-ussd" //pour le mode validation par le promoteur
                   //"command-id: process-check-subscriber" //pour checker les infos du promoteur
                   "command-id: process-create-mror-otp" //pour la génération d'OTP par moov
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
            curl_close($curl);
            // Gestion des erreurs
            //dd($response);
            if ($err) {
                                                        
                session()->flash('error', "Le service de paiement est momentanément injoignable. Veuillez réessayer dans quelques instants.");
                return redirect()->route('demande.liste');
            }
            if ($response){
                //ENregistrement dans la table paiement en cas de response
                $responseData = json_decode($response, true);
                $status = $responseData['status'];
                if($status !=12){
                // Récupérer les valeurs nécessaires
                $requestId = $responseData['request-id'];
                $status = $responseData['status'];
                $transId = $responseData['trans-id'];
                $message = $responseData['message'];
                $paiement=Paiement::create([
                    'numero_demande'=>$command,
                    'statut'=>$status,
                    'mode_paiement'=>'MoovMoney',
                    'paid_sum'=>$montant,
                    'transId'=>$transId,
                    'message'=>$message,
                    'numero_tel'=>$numero,
                    'type'=>0,// Pour initiation du paiement moovMoney
                    'requestId'=>$requestId //peut être égal à numero_demande
                ]);

                $date=new \DateTime();
                    $date_format= $date->format("d-m-Y H:i:s");
                    $id->update([
                        'paye'=>2,
                        'date_initiation'=>$date_format
                    ]);
               
                //dd($status); checked if status is ok
                if($status==0){
                    //dd('ok');
                    $otp=1; //signifie que otp a été envoyé au client, donc on peut le redirigéer ver page OTP
                    //session()->flash('message', "OTP généré avec succès ! Renseigner le code OTP");
                    return view('moov.index', compact('demande_id', 'command', 'montant','otp','transId','requestId','numero'));
                }
                elseif($status==10){
                    $paiement->update([
                        'echec_moov'=>'Oui'
                    ]);
                    $date=new \DateTime();
                    $date_format= $date->format("d-m-Y H:i:s");
                    $id->update([
                        'paye'=>0,
                        'date_initiation'=>$date_format
                    ]);
                    session()->flash('error', "Solde insuffisant : rechargez votre compte Moov Money puis réessayez.");
                    return redirect()->route('demande.liste');
                }
                else{
                    $paiement->update([
                        'echec_moov'=>'Oui'
                    ]);
                    $date=new \DateTime();
                    $date_format= $date->format("d-m-Y H:i:s");
                    $id->update([
                        'paye'=>0,
                        'date_initiation'=>$date_format
                    ]);
                    session()->flash('error', "Une erreur s’est produite lors du paiement. Veuillez réessayer.");
                    return redirect()->route('demande.liste');
                }
                }
                else{
                    session()->flash('error', "Une erreur s’est produite lors du paiement. Veuillez réessayer.");
                    return redirect()->route('demande.liste');
                }
            }

        }

    // public function moov_store(Request $request){
    //     //
    //     // Préparation des données
    //     //dd($request->all());
    //     $id=Demande::where('id', $request->id)->first();
    //     $command=$id->numero_command;
    //     $demande_id=$id->id;
    //     $montant=$id->montant_total;
    //     $numero=$request->numero;
    //     $data = [
    //         "request-id"    => $command,
    //         "destination"   => $numero,
    //         "amount"        => $montant,
    //         "remarks"       => "OTP TEST",
    //         "message"       => "GENERATION OTP MOOV",
    //         "extended-data" =>
            
    //          new \stdClass()
    //         ];

    //         $curl = curl_init();
    //         //$acces= base64_encode("MAISON:OjX8eJ9rlCC4"); //Acces de test
    //         $acces= base64_encode("MAISON:G7pM3xL9vQ2nT1Fb"); //Acces de Prod
    //         $url_prod="https://196.28.245.227/tlcfzc_gw_prod/mbs-gateway/gateway/3pp/transaction/process";
    //         $url_test="https://196.28.245.227/tlcfzc_gw/api/gateway/3pp/transaction/process";

    //         //https://196.28.245.227/tlcfzc_gw_prod/mbs-gateway/gateway/3pp/transaction/process
    //         //https://196.28.245.227/tlcfzc_gw/api/gateway/3pp/transaction/process
    //         curl_setopt_array($curl, [
    //             CURLOPT_URL            => "https://196.28.245.227/tlcfzc_gw_prod/mbs-gateway/gateway/3pp/transaction/process",
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING       => "UTF-8",
    //             CURLOPT_MAXREDIRS      => 10,
    //             CURLOPT_TIMEOUT        => 30,
    //             CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_SSL_VERIFYHOST => false,
    //             CURLOPT_SSL_VERIFYPEER => false,
    //             CURLOPT_CUSTOMREQUEST  => "POST",
    //             CURLOPT_POSTFIELDS     => json_encode($data),
    //             CURLOPT_HTTPHEADER     => [
    //                 "Authorization: Basic ".$acces, // À remplacer par vos credentials
    //                 "Content-Type: application/json",
    //                //"command-id: mror-transaction-ussd" //pour le mode validation par le promoteur
    //                //"command-id: process-check-subscriber" //pour checker les infos du promoteur
    //                "command-id: process-create-mror-otp" //pour la génération d'OTP par moov
    //             ],
    //         ]);
    //         $response = curl_exec($curl);
    //         $err = curl_error($curl);
    //         $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
    //         curl_close($curl);
    //         // Gestion des erreurs
    //         //dd($response);
    //         if ($err) {
                                                        
    //             session()->flash('error', "Le service de paiement est momentanément injoignable. Veuillez réessayer dans quelques instants.");
    //             return redirect()->route('demande.liste');
    //         }

    //         if ($response){
    //             //ENregistrement dans la table paiement en cas de response
    //             $responseData = json_decode($response, true);
    //             // Récupérer les valeurs nécessaires
    //             $requestId = $responseData['request-id'];
    //             $status = $responseData['status'];
    //             $transId = $responseData['trans-id'];
    //             $message = $responseData['message'];
    //             $paiement=Paiement::create([
    //                 'numero_demande'=>$command,
    //                 'statut'=>$status,
    //                 'mode_paiement'=>'MoovMoney',
    //                 'paid_sum'=>$montant,
    //                 'transId'=>$transId,
    //                 'message'=>$message,
    //                 'numero_tel'=>$numero,
    //                 'type'=>0,// Pour initiation du paiement moovMoney
    //                 'requestId'=>$requestId //peut être égal à numero_demande
    //             ]);

    //             $date=new \DateTime();
    //                 $date_format= $date->format("d-m-Y H:i:s");
    //                 $id->update([
    //                     'paye'=>2,
    //                     'date_initiation'=>$date_format
    //                 ]);
               
    //             //dd($status); checked if status is ok
    //             if($status==0){
    //                 //dd('ok');
    //                 $otp=1; //signifie que otp a été envoyé au client, donc on peut le redirigéer ver page OTP
    //                 //session()->flash('message', "OTP généré avec succès ! Renseigner le code OTP");
    //                 return view('moov.index', compact('demande_id', 'command', 'montant','otp','transId','requestId','numero'));
    //             }
    //             elseif($status==10){
    //                 $paiement->update([
    //                     'echec_moov'=>'Oui'
    //                 ]);
    //                 $date=new \DateTime();
    //                 $date_format= $date->format("d-m-Y H:i:s");
    //                 $id->update([
    //                     'paye'=>0,
    //                     'date_initiation'=>$date_format
    //                 ]);
    //                 session()->flash('error', "Solde insuffisant : rechargez votre compte Moov Money puis réessayez.");
    //                 return redirect()->route('demande.liste');
    //             }
    //             else{
    //                 $paiement->update([
    //                     'echec_moov'=>'Oui'
    //                 ]);
    //                 $date=new \DateTime();
    //                 $date_format= $date->format("d-m-Y H:i:s");
    //                 $id->update([
    //                     'paye'=>0,
    //                     'date_initiation'=>$date_format
    //                 ]);
    //                 session()->flash('error', "Une erreur s’est produite lors du paiement. Veuillez réessayer.");
    //                 return redirect()->route('demande.liste');
    //             }
    //         }

    //     }

        // public function moov_verif_otp(Request $request){
        //     //dd($request->all());
        //     $id=Demande::where('id', $request->id)->first();
        //     $montant=$id->montant_total;
        //     $date = date('dmy'); // Donnera "170725" pour le 17 juillet 2025 (aujourd'hui)
        //     $time = date('His');
        //     //dd($request->otp);
        //     if($id){
        //     $data = [
        //         "request-id"    => $date.'-'.$time.'-'.$id->numero_command,
        //         "destination"   => $request->numero,
        //         "amount"        => $montant,
        //         "remarks"       => "OTP VERIFICATION",
        //        // "message"       => "PAIEMENT MOOV VEUILLEZ CONFIRMER AVEC LE PIN",
        //         "extended-data" =>
        //             [
        //                  "module"=> "MERCHOTPPAY",
        //                  "otp"=> $request->otp,
        //                  "ext1"=> $date.$time,
        //                  "ext2"=> $date.$time."ext2",
        //                  "trans-id"=> $request->transId,
        //             ]
        //         ];

        //         $curl = curl_init();
        //         $acces= base64_encode("MAISON:G7pM3xL9vQ2nT1Fb");
        //         curl_setopt_array($curl, [
        //             CURLOPT_URL            => "https://196.28.245.227/tlcfzc_gw_prod/mbs-gateway/gateway/3pp/transaction/process",
        //             CURLOPT_RETURNTRANSFER => true,
        //             CURLOPT_ENCODING       => "UTF-8",
        //             CURLOPT_MAXREDIRS      => 10,
        //             CURLOPT_TIMEOUT        => 30,
        //             CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        //             CURLOPT_SSL_VERIFYHOST => false,
        //             CURLOPT_SSL_VERIFYPEER => false,
        //             CURLOPT_CUSTOMREQUEST  => "POST",
        //             CURLOPT_POSTFIELDS     => json_encode($data),
        //             CURLOPT_HTTPHEADER     => [
        //                 "Authorization: Basic ".$acces, // À remplacer par vos credentials
        //                 "Content-Type: application/json",
        //                //"command-id: mror-transaction-ussd" //pour le mode validation par le promoteur
        //                //"command-id: process-check-subscriber" //pour checker les infos du promoteur
        //                "command-id: process-commit-otppay" //pour checker l'OTP
        //             ],
        //         ]);
        //         $response = curl_exec($curl);
        //         $err = curl_error($curl);
        //         $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                
        //         curl_close($curl);

        //         if($response){
        //             //dd($response);
        //             $responseData = json_decode($response, true);
        //             // Récupérer les valeurs nécessaires
        //             $requestId = $responseData['request-id'];
        //             $status = $responseData['status'];
        //             $transId = $responseData['trans-id'];
        //             $message = $responseData['message'];
        //             $paiement=Paiement::create([
        //                 'numero_demande'=>$id->numero_command,
        //                 'statut'=>$status,
        //                 'mode_paiement'=>'MoovMoney',
        //                 'paid_sum'=>$montant,
        //                 'transId'=>$transId,
        //                 'message'=>$message,
        //                 'type'=>1,// Pour confirmation du paiement moovMoney
        //                 'requestId'=>$requestId //peut être égal à numero_demande
        //             ]);     
                                            
        //             //dd($status);
        //             if($status==0){
        //                 //dd('ok');
        //                 $date=new \DateTime();
        //                 $date_format= $date->format("d-m-Y H:i:s");
        //                 $id->update([
        //                     'paye'=>1,
        //                     'date_paiement'=>$date_format
        //                 ]);
        //                 session()->flash('message', "Paiement effectué avec succès. Votre demande est transmise au CEFORE pour traitement.");
        //                 return redirect()->route('demande.liste');
        //                 //return view('moov.index', compact('demande_id', 'command', 'montant','otp','transId','requestId','numero'));
        //             }
        //             if($status==900228){
        //                 $date=new \DateTime();
        //                 $date_format= $date->format("d-m-Y H:i:s");
        //                 $id->update([
        //                     'paye'=>0                                    
        //                 ]);
        //                 session()->flash('error', "Le code OTP est incorrect ou a expiré. Veuillez recommencer le paiement.");
        //                 return redirect()->route('demande.liste');
        //             }
        //         }
        //     }           
        // }

        public function moov_verif_otp(Request $request){
            //dd($request->all());
            $id=Demande::where('id', $request->id)->first();
            //Convertir le montant en chiffre au cas ou ce n'est pas le cas
            $montant= (int) $id->montant_total;
            $date = date('dmy'); // Donnera "170725" pour le 17 juillet 2025 (aujourd'hui)
            $time = date('His');
            //dd($request->otp);
            if($id){
            $data = [
                "request-id"    => $date.'-'.$time.'-'.$id->numero_command,
                "destination"   => $request->numero,
                "amount"        => $montant,
                "remarks"       => "OTP VERIFICATION",
               // "message"       => "PAIEMENT MOOV VEUILLEZ CONFIRMER AVEC LE PIN",
                "extended-data" =>
                    [
                         "module"=> "MERCHOTPPAY",
                         "otp"=> $request->otp,
                         "ext1"=> $date.$time,
                         "ext2"=> $date.$time."ext2",
                         "trans-id"=> $request->transId,
                    ]
                ];

                $curl = curl_init();
                $acces = base64_encode(env('USER_API_MOOV') . ':' . env('MDP_API_MOOV'));
                curl_setopt_array($curl, [
                    CURLOPT_URL            => env('URL_API_MOOV'),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => "UTF-8",
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 30,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_CUSTOMREQUEST  => "POST",
                    CURLOPT_POSTFIELDS     => json_encode($data),
                    CURLOPT_HTTPHEADER     => [
                        "Authorization: Basic ".$acces, // À remplacer par vos credentials
                        "Content-Type: application/json",
                       //"command-id: mror-transaction-ussd" //pour le mode validation par le promoteur
                       //"command-id: process-check-subscriber" //pour checker les infos du promoteur
                       "command-id: process-commit-otppay" //pour checker l'OTP
                    ],
                ]);
                $response = curl_exec($curl);
                $err = curl_error($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                
                curl_close($curl);
                //dd($response);
                if($response){
                    //dd($response);
                    
                    $responseData = json_decode($response, true);
                    // Récupérer les valeurs nécessaires
                    //dd($responseData);

                    
                    $status = $responseData['status'];                           
                    $message = $responseData['message'];
                    if($status !=12){
                        $requestId = $responseData['request-id'];
                        $transId = $responseData['trans-id'];
                        $status = $responseData['status'];                           
                        $message = $responseData['message'];
                    Paiement::create([
                        'numero_demande'=>$id->numero_command,
                        'statut'=>$status,
                        'mode_paiement'=>'MoovMoney',
                        'paid_sum'=>$montant,
                        'transId'=>$transId,
                        'message'=>$message,
                        'type'=>1,// Pour confirmation du paiement moovMoney
                        'requestId'=>$requestId //peut être égal à numero_demande
                    ]);     
                                            
                    //dd($status);
                    if($status==0){
                        //dd('ok');
                        $date=new \DateTime();
                        $date_format= $date->format("d-m-Y H:i:s");
                        $id->update([
                            'paye'=>1,
                            'date_paiement'=>$date_format
                        ]);
                        session()->flash('message', "Paiement effectué avec succès. Votre demande est transmise au CEFORE pour traitement.");
                        return redirect()->route('demande.liste');
                        //return view('moov.index', compact('demande_id', 'command', 'montant','otp','transId','requestId','numero'));
                    }
                    if($status==900228){
                        $date=new \DateTime();
                        $date_format= $date->format("d-m-Y H:i:s");
                        $id->update([
                            'paye'=>0                                    
                        ]);
                        session()->flash('error', "Le code OTP est incorrect ou a expiré. Veuillez recommencer le paiement.");
                        return redirect()->route('demande.liste');
                    }
                    }
                    else{
                        $id->update([
                            'paye'=>0                                    
                        ]);
                        session()->flash('error', "Une erreur s’est produite lors du paiement. Veuillez réessayer.");
                        return redirect()->route('demande.liste');
                    }
                }
            }           
        }    

        
        public function typeEntreprise(Request $request){
            $usager = Usager::where('user_id', Auth::user()->id)->first();
            $demande=Demande::where('usager_id', $usager->id)->first();
            $typeDemande='';
            if($demande){
                $typeDemande=$demande->company_type;
            }
            
            return view('demande.type', compact('usager', 'typeDemande'));
            
        }
    
        public function processTypeEntreprise($type)
        {
            //dd($type);
            // Validation du type
            if (!in_array($type, ['ei', 'es', 'gie'])) {
                return redirect()->route('type.entreprise')
                    ->with('error', 'Type d\'entreprise invalide.');
            }
            $user = Auth::user();
            $usager = Usager::where('user_id', $user->id)->first();
            // Récupérer toutes les pièces jointes de l'usager
            $piecejointe_enrs = PieceJointe::where('usager_id', $usager->id)->where('demande_id', null)->get();
            // Grouper par catégorie pour l'affichage
            if($piecejointe_enrs){
                    $documentsParCategorie = $piecejointe_enrs
                    ->where('type_entreprise', $type) // Filtrer par type d'entreprise                   
                    ->groupBy('categorie_piece')->map(function ($docs) {
                        // Prendre le document le plus récent pour chaque catégorie
                        return $docs->sortByDesc('created_at')->first();
                    });
                }
                else{
                    $documentsParCategorie = [];
                }
            // Stocker le type d'entreprise en session
            session(['type_entreprise_selectionne' => $type]);
            
            // Rediriger directement vers la page des pièces jointes
            //return redirect()->route('pieces-jointes.create');
            if($type=='ei'){
                return view('demande.piecepp', compact('type', 'documentsParCategorie', 'usager'));
            }else if($type=='es'){
                return view('demande.piecepm', compact('type', 'documentsParCategorie', 'usager'));
                }else{
                    return view('demande.piecepm', compact('type', 'documentsParCategorie', 'usager')); 
            }
        }

}
