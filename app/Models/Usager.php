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
    
}
