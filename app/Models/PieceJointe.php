<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceJointe extends Model
{
    use HasFactory;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $guarded=[];
    public function demande(){
        return $this->belongsTo(Demande::class,'demande_id');
     }
}

