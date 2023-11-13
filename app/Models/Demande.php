<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $dateFormat = 'd-m-Y H:i:s';
    use HasFactory;
    protected $guarded=[];
}
