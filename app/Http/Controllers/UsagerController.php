<?php

namespace App\Http\Controllers;
use App\Models\Usager;
use App\Models\PieceJointe;
use App\Models\UsagerConjoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsagerController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['verifier_nom_commercial']]);
        $this->middleware('auth');
    }

    // public function create(){
    //     $usager= Usager::where('user_id', Auth::user()->id)->first();
    //     if(!$usager){
    //         $regions= DB::table('regions')->get();
    //         $pays= DB::table('valeurs')->where('parametre_id',5)->orderby('libelle','asc')->get();
    //         $civilites=DB::table('valeurs')->where('parametre_id',15)->get();
    //         $nationalites= DB::table('valeurs')->where('parametre_id',6)->orderby('libelle','asc')->get();
    //         $professions= DB::table('valeurs')->where('parametre_id',8)->orderby('libelle','asc')->get();
    //         $all_usagers= Usager::all();
    //         return view('usager.create', compact('civilites','nationalites','regions', 'pays', 'professions','all_usagers'));
    //     }
    //     else{
    //         $piecejointe_enrs= PieceJointe::where('usager_id',$usager->id)->where('demande_id', null)->get();
    //         if(count($piecejointe_enrs)>0){
    //             $type_entreprise = $piecejointe_enrs->first()->type_entreprise ?? null;
    //             return redirect()->route('process.type.entreprise', ['type' => $type_entreprise]);
    //         }
    //         else{
    //             return redirect()->route('type.entreprise');
    //         }
    //         //return redirect()->route('create.demande');
    //     }
       
    // }
    public function create(){
        //dd($request->all());
        $usager= Usager::where('user_id', Auth::user()->id)->first();
        if(!$usager){
            $regions = DB::table('regions')->get();
            $pays = DB::table('valeurs')->where('parametre_id',5)->orderby('libelle','asc')->get();
            $civilites = DB::table('valeurs')->where('parametre_id',15)->get();
            $nationalites = DB::table('valeurs')->where('parametre_id',6)->orderby('libelle','asc')->get();
            $professions = DB::table('valeurs')->where('parametre_id',8)->orderby('libelle','asc')->get();
            $all_usagers = collect();
            return view('usager.create', compact('civilites','nationalites','regions', 'pays', 'professions','all_usagers'));
        }
        else{
            $piecejointe_enrs = PieceJointe::where('usager_id',$usager->id)->where('demande_id', null)->get();
            
            if(count($piecejointe_enrs) > 0){
                $type_entreprise = $piecejointe_enrs->first()->type_entreprise ?? null;
                
                if($type_entreprise) {
                    return redirect()->route('process.type.entreprise', ['type' => $type_entreprise]);
                }
                else {
                    $piece_pp = ['certificat_de_residence','photo_didentite','formulaire_dem_cpc'];
                    $piece_pm = ['statut','formulaire_rccm','acte_de_depot'];
                    
                    // Récupérer tous les types de pièces joints existants
                    $types_pieces_existants = $piecejointe_enrs->pluck('categorie_piece')->toArray();
                    
                    // Vérifier si les types correspondent à piece_pp
                    $is_pp = count(array_intersect($piece_pp, $types_pieces_existants)) > 0;
                    
                    // Vérifier si les types correspondent à piece_pm
                    $is_pm = count(array_intersect($piece_pm, $types_pieces_existants)) > 0;
                    
                    // Déterminer le type d'entreprise et faire la mise à jour
                    if($is_pp && !$is_pm) {
                        // Mise à jour pour EI (Entreprise Individuelle)
                        foreach($piecejointe_enrs as $piece) {
                            $piece->update(['type_entreprise' => 'ei']);
                        }
                        return redirect()->route('process.type.entreprise', ['type' => 'ei']);
                        
                    } elseif($is_pm && !$is_pp) {
                        // Mise à jour pour ES (Entreprise Société)
                        foreach($piecejointe_enrs as $piece) {
                            $piece->update(['type_entreprise' => 'es']);
                        }
                        return redirect()->route('process.type.entreprise', ['type' => 'es']);
                        
                    } else {
                        // Cas ambigu ou les deux types sont présents
                        // Rediriger vers la sélection manuelle du type
                        return redirect()->route('type.entreprise');
                    }
                }
            }
            else {
                return redirect()->route('type.entreprise');
            }
        }
       
    }
    public function store(Request $request){
        `$request->validate(['piece_jointe_m' => 'nullable'.self::REGLE_FICHIER]);`;
        //dd($request->all());
        // $this->validate($request, [
    	// 	'nom_usager'=> "required",
    	// 	'prenom_usager'=> "required",
    	// 	'lieu_de_naissance'=> "required",
        //     'date_de_naissance'=> "required",
    	// 	'profession'=> "required",
        //     'situation_matrimoniale'=> "required",
        //     'nationalite_usager'=> "required",
        //     'region_usager'=> "required",
        //     'region_usager'=> "required",
        //     'region_usager'=> "required",
        //     'region_usager'=> "required",
        //     'region_usager'=> "required",


    	// ]);
     
        $village = DB::table('secteur_villages')->where('id',$request['secteur_usager'])->first(); 
        if($village){
            $code_village= $village->code;
        }else{
            $code_village=null;
        }

        if( $request->situation_matrimoniale != null){             
            
            $user= Auth::user()->id;             
        }
        else{
            $user=null;  
        }
      
        if( $request->civilite=="M." || $request->civilite=="MR" || $request->civilite=="EL HADJ"){
            $genre=2;
        }
        else{
            $genre=1;
        }

        $cin=Usager::where('CIN', $request->numero_piece)->first();
        if ($cin){
            //dd($cin->CIN);
            return redirect()->route('create.demande');
        }
        else{

            if($request->situation_matrimoniale==null){ 
                $situation=1;
                }
                else{
                    $situation=$request->situation_matrimoniale;
                }            
               if($request->boite_postale==null){
                    $boite_postale="NP";
                }
                else{
                    $boite_postale=$request->boite_postale;
                }
               if($request->email_usager==null){
                $email="NP";
                }
                else{
                    $email=$request->email_usager;
                }
                if($request->profession==null){
                    $professions="110";
                }
                else{
                    $professions=$request->profession;
                }

        $usager= Usager::create([
            'Type' => 1,
            'Civility' => $request['civilite'],
            'NomRaisonSociale' => $request['nom_usager'],
            'Prenom' => $request['prenom_usager'],
            'Gender' => $genre,
            'DateNaissance' => $request['date_de_naissance'],
            'LieuNaissance' => $request['lieu_de_naissance'], 
            'IdFonction' => $professions,
            'SituationMatrimoniale' => $situation,
            'IdCategorieUsager' => 4,
            "Nationality_No_"=>$request['nationalite_usager'],
            "Country_Code"=>$request['pays_usager'],
            "Region_Code"=>$request['region_usager'],
            'Province_Code'=> $request ['province_usager'],
            'Commun_Departement_Code' => $request ['commune_usager'],
            'Arrondissement_Code'=> $request ['arrondissement_usager'],
            'Code_Secteur_Village' => $code_village, 
            'Boite_postale' => $boite_postale,
            'Phone_No_' => $request['telephone_mobile1'],
            'Tel_Bureau' => $request['telephone_bureau'],
            'IdAdresse' => $request['adresse'],
            'user_id' => $user,
            'E-Mail'=>$email,
           // 'IdAdresse'=>$request['boite_postale'],
            'CIN'=>$request->numero_piece,
            'titre' => $request['civilite']
        ]);

        if($request->hasFile('piece_jointe_m')) {
            $file = $request->file('piece_jointe_m');
            //dd($file);
            $extension=$file->getClientOriginalExtension();
            $type_doc="acte_de_mariage";
            $fileName = $type_doc.'.'.$extension;
            //Definir l'emplacement de sorte à créer un sous repertoire pour chaque entreprise
           // $fileName = $file->getClientOriginalName();
//dd($file);
            $emplacement='public/files/'.$usager->id;
            $file_url= $request['piece_jointe_m']->storeAs($emplacement, $fileName);
            $url_local= $usager->id.'/'.$fileName;
            $docName = $type_doc;
           // $file = $request->file('piece_jointe_1')->storeAs('public/casier', $docName.'.'.$guessExtension);
            $piecejointe_enrs= PieceJointe::where('usager_id',$usager->id)->where('type_piece', $type_doc)->get();
           // dd(count($piecejointe_enrs));
        if(count($piecejointe_enrs)==0)
        {
            $date = new \DateTime();
            $pj= PieceJointe::create([
                'usager_id'=>$usager->id,
                'type_piece'=> 'acte_mariage',
                'url'=> $file_url,
                'numero'=> 'test',
                'date_etablissement'=> $date,
                'lieu_etablissement' => 'test',
                'categorie_piece'=> 'acte_mariage',
                'url_local'=>$url_local,
                'file_extension'=>$extension
            ]);
            // if ($pj) {
            //     $data_json= array('data'=>'success','status'=>'201', 'type_doc'=>'test');
            //     return json_encode($data_json);
            // }
            // else{
            //     $data_json = array('data'=>'fail','status'=>'400', 'type_doc'=>'test');
            //     return json_encode($data_json);
            // }
        }
        }
        
        if($request->hasFile('piece_jointe_c')) {
            $file = $request->file('piece_jointe_c');
            //dd($file);
            $extension=$file->getClientOriginalExtension();
            $type_doc="autorisation_de_commerce";
            $fileName = $type_doc.'.'.$extension;
            //Definir l'emplacement de sorte à créer un sous repertoire pour chaque entreprise
           // $fileName = $file->getClientOriginalName();
//dd($file);
            $emplacement='public/files/'.$usager->id;
            $file_url= $request['piece_jointe_c']->storeAs($emplacement, $fileName);
            $url_local= $usager->id.'/'.$fileName;
            $docName = $type_doc;
           // $file = $request->file('piece_jointe_1')->storeAs('public/casier', $docName.'.'.$guessExtension);
            $piecejointe_enrs= PieceJointe::where('usager_id',$usager->id)->where('type_piece', $type_doc)->get();
           // dd(count($piecejointe_enrs));
        if(count($piecejointe_enrs)==0)
        {
            $date = new \DateTime();
            $pj= PieceJointe::create([
                
                'usager_id'=>$usager->id,
                'type_piece'=> 'autorisation_de_commerce',
                'url'=> $file_url,
                'numero'=> 'test',
                'date_etablissement'=> $date,
                'lieu_etablissement' => 'test',
                'categorie_piece'=> 'autorisation_de_commerce',
                'url_local'=>$url_local,
                'file_extension'=>$extension
            ]);
            // if ($pj) {
            //     $data_json= array('data'=>'success','status'=>'201', 'type_doc'=>'test');
            //     return json_encode($data_json);
            // }
            // else{
            //     $data_json = array('data'=>'fail','status'=>'400', 'type_doc'=>'test');
            //     return json_encode($data_json);
            // }
        }
        }
        //dd(count($request['conjoints']));
        if( $request['conjoints']){
            $conjoints =$request['conjoints'];
        foreach( $conjoints as $conjoint){
            if($conjoint){
                UsagerConjoint::create([
                    'usager_id'=>$usager->id,
                    'conjoint_id'=>$conjoint,
                    'regime_matrimonial'=>$request->regime_matrimonial,
                    'date_mariage'=>$request->date_mariage,
                    'lieu_mariage'=>$request->lieu_mariage
                ]);
            }
        }
           
        }
        //Ce controle permet de savoir si c'est un usager qui est créer pour une demande ou un usager creer pour completer mles information d'un autre usager 
        //tel que le conjoint ou autre
    if( $request ['province_usager'] != null){             
        //return redirect()->route('create.demande');    
        return redirect()->route('type.entreprise')
        ->with('success', 'Usager créé avec succès. Vous pouvez maintenant créer une demande.');  
    }
   
    else{
            // $usagers= Usager::all();
            //     foreach ($usagers as $usager) {
            //         $data[] = array("id" => $usager->id, "nom" => $usager->NomRaisonSociale,'prenom'=>$usager->Prenom,'phone'=>$usager->Phone_No_,);
            //     }  

            $data=[
                'success'=>200,
                'message'=>'Créé avec succès'
            ];       
                return json_encode($data);
                //return redirect()->route('create.demande');      

       }
     
    }
    }
    
    public function promoteur()
    {
        $usagers= Usager::where('id', '!=', null)->orderBy('updated_at', 'desc')
        //->take(100)
        ->get();
        return view('usager.adminliste', compact('usagers'));
    }

    public function rechercher(Request $request)
    {
        $request->validate(['q' => 'required|string|min:6|max:30']);

        // Correspondance EXACTE uniquement : impossible de parcourir la base
        $usager = Usager::where('CIN', trim($request->q))
            ->first(['id', 'CIN', 'NomRaisonSociale', 'Prenom']);

        if (!$usager) {
            return response()->json(['results' => []]);
        }

        return response()->json(['results' => [[
            'id'   => $usager->id,
            'text' => $usager->CIN.' - '.$usager->NomRaisonSociale.' '.mb_substr((string) $usager->Prenom, 0, 1).'.',
        ]]]);
    }
}
