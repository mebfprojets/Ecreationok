<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    protected $connection = 'sqlsrv';
    use HasFactory;
    protected $guarded=[];

}
