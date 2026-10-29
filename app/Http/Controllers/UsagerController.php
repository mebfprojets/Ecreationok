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
        // Deux usages : profil du promoteur connecté (formulaire classique, province_usager renseignée)
        // ou ajout d'un conjoint / associé / dirigeant depuis une fenêtre (appel AJAX).
        $estAjax = $request->ajax() || $request->expectsJson();

        $request->validate([
            'numero_piece' => ['required_without:numero_ifu', 'nullable', 'string', 'max:50', function ($attribut, $valeur, $echec) {
                $numero = mb_strtoupper(trim((string) $valeur));
                if ($numero !== '' && Usager::whereRaw('UPPER(LTRIM(RTRIM(CIN))) = ?', [$numero])->exists()) {
                    $echec('Un promoteur est enregistré dans la base avec les mêmes informations.');
                }
            }],
            'nom_usager' => 'nullable|string|max:255',
            'prenom_usager' => 'nullable|string|max:255',
            'email_usager' => 'nullable|email|max:255',
            'telephone_mobile1' => 'nullable|string|max:30',
            'piece_jointe_m' => 'nullable|'.self::REGLE_FICHIER,
            'piece_jointe_c' => 'nullable|'.self::REGLE_FICHIER,
        ], [
            'numero_piece.required_without' => 'Le numéro de la pièce d’identité est obligatoire.',
            'numero_piece.max' => 'Le numéro de la pièce d’identité est trop long (50 caractères au maximum).',
            'nom_usager.max' => 'Le nom est trop long (255 caractères au maximum).',
            'prenom_usager.max' => 'Le prénom est trop long (255 caractères au maximum).',
            'email_usager.email' => 'L’adresse e-mail du promoteur n’est pas valide.',
            'telephone_mobile1.max' => 'Le numéro de téléphone est trop long.',
            'piece_jointe_m.file' => 'L’acte de mariage n’a pas été reçu correctement. Sélectionnez de nouveau le fichier.',
            'piece_jointe_m.mimes' => 'L’acte de mariage doit être un fichier PDF, JPG ou PNG.',
            'piece_jointe_c.file' => 'L’autorisation de commerce n’a pas été reçue correctement. Sélectionnez de nouveau le fichier.',
            'piece_jointe_c.mimes' => 'L’autorisation de commerce doit être un fichier PDF, JPG ou PNG.',
            'piece_jointe_m.max' => 'L’acte de mariage ne doit pas dépasser 10 Mo.',
            'piece_jointe_c.max' => 'L’autorisation de commerce ne doit pas dépasser 10 Mo.',
            'piece_jointe_m.uploaded' => 'L’acte de mariage n’a pas pu être envoyé : il est probablement trop volumineux.',
            'piece_jointe_c.uploaded' => 'L’autorisation de commerce n’a pas pu être envoyée : elle est probablement trop volumineuse.',
        ]);

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

        DB::beginTransaction();
        try {

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
            'CIN'=>$request->numero_piece !== null ? trim($request->numero_piece) : null,
            'titre' => $request['civilite']
        ]);

        // Pièces jointes facultatives : acte de mariage et autorisation de commerce
        $pieces = [
            'piece_jointe_m' => ['fichier' => 'acte_de_mariage', 'type' => 'acte_mariage'],
            'piece_jointe_c' => ['fichier' => 'autorisation_de_commerce', 'type' => 'autorisation_de_commerce'],
        ];
        foreach ($pieces as $champ => $piece) {
            if (! $request->hasFile($champ)) {
                continue;
            }
            $file = $request->file($champ);
            $extension = strtolower($file->extension());
            $fileName = $piece['fichier'].'.'.$extension;
            //Definir l'emplacement de sorte à créer un sous repertoire pour chaque entreprise
            $emplacement='public/files/'.$usager->id;
            $file_url= $file->storeAs($emplacement, $fileName);
            $url_local= $usager->id.'/'.$fileName;

            if (PieceJointe::where('usager_id',$usager->id)->where('type_piece', $piece['type'])->doesntExist()) {
                PieceJointe::create([
                    'usager_id'=>$usager->id,
                    'type_piece'=> $piece['type'],
                    'url'=> $file_url,
                    'numero'=> 'test',
                    'date_etablissement'=> new \DateTime(),
                    'lieu_etablissement' => 'test',
                    'categorie_piece'=> $piece['type'],
                    'url_local'=>$url_local,
                    'file_extension'=>$extension
                ]);
            }
        }

        if( $request['conjoints']){
            foreach( (array) $request['conjoints'] as $conjoint){
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

        DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            $message = 'L’enregistrement du promoteur n’a pas pu aboutir. Vérifiez les informations saisies puis réessayez ; '
                .'si le problème persiste, contactez le CEFORE.';

            if ($estAjax) {
                return response()->json(['message' => $message], 500);
            }

            return redirect()->back()
                ->withInput($request->except(['piece_jointe_m', 'piece_jointe_c', '_token']))
                ->with('error', $message);
        }

        //Ce controle permet de savoir si c'est un usager qui est créer pour une demande ou un usager creer pour completer mles information d'un autre usager
        //tel que le conjoint ou autre
        if( $request ['province_usager'] != null && ! $estAjax){
            return redirect()->route('type.entreprise')
            ->with('success', 'Usager créé avec succès. Vous pouvez maintenant créer une demande.');
        }

        return response()->json([
            'success' => 200,
            'message' => 'Promoteur enregistré avec succès.',
            'usager' => [
                'id' => $usager->id,
                'text' => $usager->CIN.' - '.$usager->NomRaisonSociale.' '.mb_substr((string) $usager->Prenom, 0, 1).'.',
            ],
        ]);
    }

    public function promoteur()
    {
        // Données personnelles des promoteurs : agents chargés des demandes uniquement
        if (!Auth::user()->can('lister.demande')) {
            return $this->refuserAcces();
        }
        // Le tableau est rempli page par page par promoteur_donnees() (plus de 14 000 promoteurs)
        return view('usager.adminliste');
    }

    /** Liste des promoteurs au format DataTables (traitement côté serveur), limitée au CEFORE de l'agent. */
    public function promoteur_donnees(Request $request)
    {
        if (!Auth::user()->can('lister.demande')) {
            abort(403);
        }
        $p = $this->parametresTableau($request, [0 => 'usagers.NomRaisonSociale', 1 => 'usagers.DateNaissance', 2 => 'usagers.CIN',
            3 => 'usagers.created_at', 4 => 'u.email'], 'usagers.created_at');
        $siege = $this->estAgentSiege(Auth::user());
        $organisation = Auth::user()->organisation;

        $base = Usager::query()->leftJoin('users as u', 'u.id', '=', 'usagers.user_id')
            ->when(!$siege, fn ($q) => $q->whereExists(fn ($e) => $e->select(DB::raw(1))->from('demandes as d')
                ->whereColumn('d.usager_id', 'usagers.id')->where('d.organisation_code', $organisation)));
        $total = (clone $base)->count();
        if ($p['motif']) {
            $base->where(function ($q) use ($p) {
                $q->where(DB::raw("CONCAT(usagers.NomRaisonSociale, ' ', usagers.Prenom)"), 'like', $p['motif'])
                  ->orWhere(DB::raw("CONCAT(usagers.Prenom, ' ', usagers.NomRaisonSociale)"), 'like', $p['motif'])
                  ->orWhere('usagers.CIN', 'like', $p['motif'])
                  ->orWhere('u.email', 'like', $p['motif']);
            });
        }
        $filtre = (clone $base)->count();

        $usagers = $base->orderBy($p['tri'], $p['sens'])->orderBy('usagers.id', 'desc')->skip($p['debut'])->take($p['longueur'])
            ->get(['usagers.id', 'usagers.NomRaisonSociale', 'usagers.Prenom', 'usagers.DateNaissance', 'usagers.CIN', 'usagers.created_at', 'u.email as compte_email']);

        // Demandes des promoteurs de la page : une seule requête pour toutes les lignes
        $demandes = \App\Models\Demande::whereIn('usager_id', $usagers->pluck('id'))
            ->when(!$siege, fn ($q) => $q->where('organisation_code', $organisation))
            ->orderBy('created_at', 'desc')
            ->get(['id', 'usager_id', 'commercial_name', 'denomination_social', 'etat', 'paye', 'created_at'])
            ->groupBy('usager_id');

        $date = function ($v, $format = 'd/m/Y') {
            if (!$v) { return '—'; }
            try { return \Carbon\Carbon::parse($v)->format($format); } catch (\Throwable $e) { return e($v); }
        };
        $lignes = $usagers->map(function ($u) use ($demandes, $date) {
            $liste = $demandes->get($u->id, collect());
            $derniere = $liste->first();
            if ($derniere) {
                [$libelle, $couleur] = (int) $derniere->paye !== 1 ? ['Non payée', 'secondary']
                    : ([1 => ['Validée', 'success'], 2 => ['Rejetée', 'danger']][(int) $derniere->etat] ?? ['À valider', 'warning']);
                $demandeHtml = '<a href="'.e(route('detail.demande', $derniere->id)).'" class="fw-semibold text-decoration-none">'
                    .e($derniere->commercial_name ?: $derniere->denomination_social).'</a> <span class="badge text-bg-'.$couleur.'">'.$libelle.'</span>'
                    .'<div class="small text-muted">du '.$date($derniere->created_at).'</div>';
            } else {
                $demandeHtml = '<span class="text-muted">Aucune demande</span>';
            }
            return [
                e(trim($u->NomRaisonSociale.' '.$u->Prenom)),
                $date($u->DateNaissance),
                $u->CIN ? e($u->CIN) : '—',
                $date($u->created_at),
                $u->compte_email ? e($u->compte_email) : '<span class="text-muted">Aucun compte</span>',
                $demandeHtml,
                $liste->count(),
            ];
        });

        return response()->json(['draw' => (int) $request->input('draw'), 'recordsTotal' => $total, 'recordsFiltered' => $filtre, 'data' => $lignes]);
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
