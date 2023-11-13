<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table='password_resets';
    use HasFactory;
    protected $guarded=[];
    public $timestamps = false ;

//     public function fromDateTime($value)
// {
//     return Carbon::parse(parent::fromDateTime($value))->format('Y-d-m H:i:s');
// }

}
