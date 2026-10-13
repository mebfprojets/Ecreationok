<?php

namespace App\Http\Controllers;

use App\Models\PieceJointe;
use App\Models\Usager;
use App\Models\Demande;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PieceJointeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        //$this->middleware('auth', ['except' => ['verifier_nom_commercial']]);
        $this->middleware('auth');
    }
    public function index()
    {
        //
        $user = Auth::user();
        $usager = Usager::where('user_id', $user->id)->first();
        // Récupérer toutes les pièces jointes de l'usager
        $piecejointe_enrs = PieceJointe::where('usager_id', $usager->id)->where('demande_id', null)->get();
        // Grouper par catégorie pour l'affichage
        $documentsParCategorie = $piecejointe_enrs->groupBy('categorie_piece')->map(function ($docs) {
            // Prendre le document le plus récent pour chaque catégorie
            return $docs->sortByDesc('created_at')->first();
        });
        //dd($documentsParCategorie);
        return view("demande.piecepm", compact('usager','documentsParCategorie'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       // dd($request->all());
      //dd($request->statut);
        $user = Auth::user();
        $usager = Usager::where('user_id', $user->id)->first();
        $type_entreprise = $request->type_entreprise;
        
        if($request->hasFile('declaration')) {$declaration=$request->file('declaration');}else {$declaration=null;}
        if($request->hasFile('acte_de_depot')) {$acte_de_depot=$request->file('acte_de_depot');}else {$acte_de_depot=null;}
        if($request->hasFile('statut')) {$statut=$request->file('statut');}else {$statut=null;}
        if($request->hasFile('formulaire_rccm')) {$formulaire_rccm=$request->file('formulaire_rccm');}else {$formulaire_rccm=null;}
        if($request->hasFile('piece_didentite')) {$piece_didentite=$request->file('piece_didentite');}else {$piece_didentite=null;}
        if($request->hasFile('titre_de_propriete')) {$titre_de_propriete=$request->file('titre_de_propriete');}else {$titre_de_propriete=null;}
        if($request->hasFile('formulaire_cpc_es')) {$formulaire_cpc_es=$request->file('formulaire_cpc_es');}else {$formulaire_cpc_es=null;}
        if($request->hasFile('formulaire_dem_cpc')) {$formulaire_dem_cpc=$request->file('formulaire_dem_cpc');}else {$formulaire_dem_cpc=null;}
        if($request->hasFile('certificat_de_residence')) {$certificat_de_residence=$request->file('certificat_de_residence');}else {$certificat_de_residence=null;}
        if($request->hasFile('photo_didentite')) {$photo_didentite=$request->file('photo_didentite');}else {$photo_didentite=null;}
        
        // ✅ Récupération des infos CNIB
        $reference = $request->reference;
        $date_etablissement = $request->date_etablissement;
        $date_expiration = $request->date_expiration;

        
        $data= [
            'declaration' => $declaration,
            'acte_de_depot' => $acte_de_depot,
            'statut' => $statut,
            'formulaire_rccm' => $formulaire_rccm,
            'piece_didentite' => $piece_didentite,
            'titre_de_propriete' => $titre_de_propriete,
            'formulaire_cpc_es' => $formulaire_cpc_es,            
            'formulaire_dem_cpc' => $formulaire_dem_cpc,
            'certificat_de_residence' => $certificat_de_residence,
            'photo_didentite' => $photo_didentite,
        ];
        //dd($data);
        try {
            // Traitement de chaque fichier
            foreach ($data as $category => $file) {
                //$this->processFile($file, $category, $usager);
                if ($file !== null) {
                    //dd($category);
                    $this->processFile($file, 
                    $category, $usager, $type_entreprise,
                    $reference,
                    $date_etablissement,
                    $date_expiration
                    );
                }
            }

            if($request->url=="detailfront"){
                return redirect()->back()
                ->with('success', 'Les pièces jointes ont été uploadées avec succès');
            }
            else{
                return redirect()->route('create.demande')
                ->with('success', 'Toutes les pièces jointes ont été uploadées avec succès.');
            }
            

        } catch (\Exception $e) {
            \Log::error('Erreur upload pièces jointes: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'upload des fichiers.')
                ->withInput();
        }
    }


        private function processFile($file, $category, $usager, $type_entreprise, $reference=null, $date_etablissement=null, $date_expiration=null)
    {
        //dd($file, $category, $usager, $type_entreprise, $reference, $date_etablissement, $date_expiration);
        
        $extension = $file->getClientOriginalExtension();
        //dd($extension);
        $type_doc = $this->getTypePiece($category);
        $date= now()->format('Y-m-d');


         // Déterminer la date d'établissement selon le type de document
        if($type_doc == 'piece_didentite') {
            $numero = $reference ?? 'CNIB';
            // Pour la pièce d'identité, on utilise la date_etablissement fournie
            $date_etablissement_finale = $date_etablissement;
        } else {
            // Pour tous les autres types, on utilise la date du jour
            $date_etablissement_finale = $date;
            
            if($type_doc == 'titre_propriete'){
                $numero = 'CB';
            } elseif($type_doc == 'declaration'){
                $numero = 'DH';
            } elseif($type_doc == 'acte_de_depot'){
                $numero = 'AD';
            } elseif($type_doc == 'statut'){
                $numero = 'STATUT';
            } elseif($type_doc == 'formulaire_rccm'){
                $numero = 'RCCM';
            } elseif($type_doc == 'formulaire_dem_cpc'){
                $numero = 'FCPC';
            } elseif($type_doc == 'certificat_de_residence'){
                $numero = 'CR';
            } elseif($type_doc == 'photo_didentite'){
                $numero = 'PHOTO';
            } elseif($type_doc == 'formulaire_cpc_es'){
                $numero = 'FCPC';
            } else {
                $numero = strtoupper($type_doc);
            }
        }
        // Compter les pièces existantes pour cet usager et ce type (votre logique)
        $pj_nbre = PieceJointe::where('usager_id', $usager->id)
            ->where('type_piece', $type_doc)
            ->get();

        if($type_doc=='piece_didentite'){
            $type_doc='cnib';
            //dd($type_doc);
        }
        
        $nbr_piece = count($pj_nbre) + 1;
        $fileName = $nbr_piece . '-' . $type_doc . '.' . $extension;
        //dd($fileName);
        // Stockage
        $emplacement = 'public/files/' . $usager->id;
        $file_url = $file->storeAs($emplacement, $fileName);
        $url_local = $usager->id . '/' . $fileName;
        //dd($file_url);
        // Vérifier s'il existe déjà un document pour cette catégorie sans demande_id
        $piecejointe_existante = PieceJointe::where('usager_id', $usager->id)
            ->where('demande_id', null)
            ->where('categorie_piece', $category)
            ->where('type_entreprise', $type_entreprise)
            ->first();
            //dd($piecejointe_existante);
        //dd($piecejointe_existante);
        if (!$piecejointe_existante) {
            // Créer un nouvel enregistrement
            PieceJointe::create([
                'usager_id' => $usager->id,
                'type_piece' => $type_doc,
                'url' => $file_url,
                'categorie_piece' => $category,
                'url_local' => $url_local,
                'file_extension' => $extension,
                'demande_id' => null,
                'numero' => $numero ?? null,
                'date_etablissement' => $date_etablissement_finale,
                'lieu_etablissement' => 'ECREATION' ?? null,
                'type_entreprise' => $type_entreprise,
            ]);
        }
        else {
            // Supprimer l'ancien fichier du stockage
           // dd($piecejointe_existante->url);
            $file_url = $file->storeAs($emplacement, $fileName);

            // Mettre à jour l'enregistrement existant
            $piecejointe_existante->update([
                'url' => $file_url,
                'url_local' => $url_local,
                'file_extension' => $extension,
                'updated_at' => now(),
            ]);
        }
    }

    private function getTypePiece($category)
    {
        $mapping = [
            'declaration' => 'declaration',
            'acte_de_depot' => 'acte_de_depot',
            'statut' => 'statut',
            'formulaire_rccm' => 'formulaire_rccm',
            'piece_didentite' => 'piece_didentite',
            'titre_de_propriete' => 'titre_propriete',
            'formulaire_cpc_es' => 'formulaire_dem_cpc',
            'formulaire_dem_cpc' => 'formulaire_dem_cpc',
            'certificat_de_residence' => 'certificat_residence',
            'photo_didentite' => 'photo_didentite',
        ];

        return $mapping[$category] ?? $category;
    }


    public function view($category)
    {
        try {
            $user = Auth::user();
            $usager = Usager::where('user_id', $user->id)->first();
            
            if (!$usager) {
                abort(404, 'Usager non trouvé');
            }

            // Récupérer le document le plus récent pour cette catégorie
            $document = PieceJointe::where('usager_id', $usager->id)
                ->where('categorie_piece', $category)
                ->orderBy('created_at', 'desc')
                ->firstOrFail();

            $filePath = storage_path('app/public/files/' . $document->url_local);
            
            if (!file_exists($filePath)) {
                abort(404, 'Fichier non trouvé');
            }

            $mimeType = mime_content_type($filePath);

            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($document->url_local) . '"'
            ]);

        } catch (\Exception $e) {
            abort(404, 'Document non trouvé');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PieceJointe  $pieceJointe
     * @return \Illuminate\Http\Response
     */
    public function show(PieceJointe $pieceJointe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PieceJointe  $pieceJointe
     * @return \Illuminate\Http\Response
     */
    public function edit(PieceJointe $pieceJointe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PieceJointe  $pieceJointe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PieceJointe $pieceJointe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PieceJointe  $pieceJointe
     * @return \Illuminate\Http\Response
     */
    public function destroy(PieceJointe $pieceJointe)
    {
        //
    }
    public function detaildocument(Piecejointe $piecejointe){
        return view("document.show", compact('piecejointe'));
    }
}
