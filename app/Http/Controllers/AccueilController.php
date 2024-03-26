<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function page_accueil(){
        if(Auth::user()->isadmin == null) {
            return redirect()->route('index');
        }
        else{
            return redirect()->route('dashboard');
        }
    }
}
