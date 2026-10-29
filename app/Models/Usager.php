<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usager extends Model
{
    protected $dateFormat = 'd-m-Y H:i:s';
    use HasFactory;
    protected $guarded=[];
    public function user(){
        return $this->belongsTo(User::class);
     }
     public function demandes(){
        return $this->hasMany(Demande::class, 'usager_id');
     }

     // Compte e-Création du promoteur (users.id = usagers.user_id).
     // L'ancienne définition (hasMany(User::class, 'id')) rattachait le compte dont l'id valait celui du promoteur.
     public function users(){
        return $this->hasMany(User::class, 'id', 'user_id');
     }
}
