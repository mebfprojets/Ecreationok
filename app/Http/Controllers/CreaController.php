<?php

namespace App\Http\Controllers;

use App\Models\Crea;
use Illuminate\Http\Request;

class CreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('demande.test');
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
        $crea= Crea::create([
            'Nom' => $request['nom'],
            'Prenom' => $request['prenom'],
            'Email' => $request['email'],
            'Phone' => $request['phone'],
            'address' => $request['address'],
            'card_number' => $request['nom'],
            'number_credit' => $request['number_credit'], 
            'declaration' => $request['nom'],
            'company' => $request['type_card'], 
           
        ]);
        dd($crea);
        //return view('demande.test');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Crea  $crea
     * @return \Illuminate\Http\Response
     */
    public function show(Crea $crea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crea  $crea
     * @return \Illuminate\Http\Response
     */
    public function edit(Crea $crea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crea  $crea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Crea $crea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crea  $crea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Crea $crea)
    {
        //
    }
}
