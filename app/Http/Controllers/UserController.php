<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\Role;
use App\Models\User;
use App\Models\Valeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
//    public function __construct()
//    {
//     $this->middleware('auth');
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // email_existe est appelé par le formulaire d'inscription, donc par un visiteur non connecté
        // (route limitée à 20 requêtes par minute dans routes/web.php)
        $this->middleware('auth')->except('email_existe');
    }
    public function index()
    {
        // Comptes des agents : réservé aux administrateurs (même droit que le menu « Administration »)
        if (!Auth::user()->can('user.create')) {
            return $this->refuserAcces();
        }
        $users= User::with("roles")->where('isadmin','!=',null)->orderBy('updated_at', 'desc')->get();
        return view('users.index', compact("users"));
    }
    public function compte()
    {
        // Comptes des promoteurs (données personnelles) : agents chargés des demandes uniquement
        if (!Auth::user()->can('lister.demande')) {
            return $this->refuserAcces();
        }
        // Le tableau est rempli page par page par compte_donnees() (plus de 15 000 comptes)
        return view('users.compte');
    }

    /** Comptes des promoteurs au format DataTables (traitement côté serveur), limités au CEFORE de l'agent. */
    public function compte_donnees(Request $request)
    {
        if (!Auth::user()->can('lister.demande')) {
            abort(403);
        }
        $p = $this->parametresTableau($request, [0 => 'users.name', 1 => 'users.email', 2 => 'users.created_at'], 'users.created_at');
        $siege = $this->estAgentSiege(Auth::user());
        $organisation = Auth::user()->organisation;

        $base = User::query()->whereNull('users.isadmin')
            ->leftJoin('usagers as us', 'us.user_id', '=', 'users.id')
            ->when(!$siege, fn ($q) => $q->whereExists(fn ($e) => $e->select(DB::raw(1))->from('demandes as d')
                ->whereColumn('d.usager_id', 'us.id')->where('d.organisation_code', $organisation)));
        $total = (clone $base)->count();
        if ($p['motif']) {
            $base->where(function ($q) use ($p) {
                $q->where('users.name', 'like', $p['motif'])->orWhere('users.prenom', 'like', $p['motif'])
                  ->orWhere('users.email', 'like', $p['motif'])
                  ->orWhere(DB::raw("CONCAT(us.NomRaisonSociale, ' ', us.Prenom)"), 'like', $p['motif']);
            });
        }
        $filtre = (clone $base)->count();

        $lignes = $base->orderBy($p['tri'], $p['sens'])->orderBy('users.id', 'desc')->skip($p['debut'])->take($p['longueur'])
            ->get(['users.id', 'users.name', 'users.prenom', 'users.email', 'users.created_at', 'users.email_verified_at',
                'us.NomRaisonSociale', 'us.Prenom as us_prenom',
                DB::raw('(SELECT COUNT(*) FROM demandes d2 WHERE d2.usager_id = us.id) AS nb_demandes')])
            ->map(fn ($u) => [
                e(trim($u->prenom.' '.$u->name)),
                e($u->email).($u->email_verified_at ? ' <i class="fas fa-check-circle text-success" title="Adresse vérifiée" aria-hidden="true"></i>' : ''),
                $u->created_at ? $u->created_at->format('d/m/Y') : '—',
                $u->NomRaisonSociale ? e(trim($u->NomRaisonSociale.' '.$u->us_prenom)) : '<span class="text-muted">Aucun</span>',
                (int) $u->nb_demandes,
            ]);

        return response()->json(['draw' => (int) $request->input('draw'), 'recordsTotal' => $total, 'recordsFiltered' => $filtre, 'data' => $lignes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    if (Auth::user()->can('user.create')) {
        $roles= Role::all();
        $organisations= Organisation::all();
        return view("users.create", compact("roles","organisations"));
     }
     else{
        
        flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
         return redirect()->back();
     }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     if (Auth::user()->can('user.create')) {
        $request->validate([
            "nom"=>"required",
            "email"=>"required|email"
        ]);
        
       $user= User::create([
            "name"=>$request['nom'],
            "email"=>$request['email'],
            'prenom'=> $request ['prenom'],
            'organisation' => $request ['organisation'],
            'telephone'=> $request ['telephone'],
            'email' => $request['email'],
            'isadmin' => 1,
            'password' => bcrypt('ecreation@2022')
        ]);
        $user->roles()->sync($request->roles);
        flash("Utilisateur ajouté avec succes !!!")->success();
        return redirect()->route("user.index");
    }
     else{
         flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
         return redirect()->back();
     }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
    if (Auth::user()->can('user.create')) {
            $roles= Role::all();
            $organisations= Organisation::all();
        return view("users.update",compact(["user","roles","organisations"]));
     }
     else{
         flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
         return redirect()->back();
     }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
     if (Auth::user()->can('user.create')) {
        $request->validate([
            'nom'=>"required",
            'email'=>"required|email"
        ]);
        
        $user->update([
            "name"=>$request['nom'],
            "email"=>$request['email'],
            'prenom'=> $request ['prenom'],
            'organisation' => $request ['organisation'],
            'telephone'=> $request ['telephone'],
            'email' => $request['email'],
           
        ]);
        $user->roles()->sync($request->roles);
        flash("Utilisateur modifié avec success !!!")->success();
        return redirect()->route("user.index");
    }
        else{
             flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
public function verifier_conformite_cpt(Request $request){ 
    $entreprises=Entreprise::where('code_promoteur',$request->code_promoteur)->where("participer_a_la_formation",1)->where("decision_du_comite_phase1","selectionnee")->get();
    $user=User::where("code_promoteur",$request->code_promoteur)->first();
    if(!$entreprises || $user){
        return 2;
    }
    elseif(count($entreprises)>0){
        return 1;
    }else{
        return 0;
    }

}
public function storecomptePromoteur(Request $request){
    $request->validate([
        'code_promoteur'=>'unique:users|max:255',
        'password' => 'required|confirmed|min:6'
    ]);
    $promoteur=Promotrice::where('code_promoteur',$request->code_promoteur)->first();
    if(isset($request['code_promoteur'], $request['email'])){
        $user= User::create([
            "name"=>$promoteur['nom'],
            "email"=>$request['email'],
            'prenom'=> $promoteur['prenom'],
            'telephone'=> $request ['telephone'],
            'email' => $request['email'],
            'code_promoteur' => $request['code_promoteur'],
            'password' => bcrypt($request['password'])
        ]);
    }
    if($user){
        return redirect()->back();
        flash("Votre compte à été créé avec success !!!")->success();

    }
    else{
        return redirect()->back();
        flash("Desolé votre compte n'a pas été créé. Bien vouloir vérifier la confirmation de mot de passe!!!")->error();

    }
   
    
}
public function logout(Request $request) {
    
        Auth::logout();
        return redirect()->route('index');
    
   
}
public function login(){
    return view('index');
}

public function email_existe(Request $request){
    $user=User::where("email",$request->username)->first();
    if($user){
         return 0;
    }
    else{
         return 1;
    }

 }

}
