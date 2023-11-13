<?php

namespace App\Http\Controllers;

use App\Models\Tests;
use Illuminate\Http\Request;

class TestsController extends Controller
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
        $crea= Tests::create([
            'Nom' => $request['nom'],
            'Prenom' => $request['prenom'],
            'Email' => $request['email'],
            'Phone' => $request['phone'],
            'address' => $request['address'],
            'Nom' => $request['nom'],
            'Prenom' => $request['prenom'], 
            'Email' => $request['email'],
            'address' => $request['address'], 
           
        ]);
        dd($crea);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tests  $tests
     * @return \Illuminate\Http\Response
     */
    public function show(Tests $tests)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tests  $tests
     * @return \Illuminate\Http\Response
     */
    public function edit(Tests $tests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tests  $tests
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tests $tests)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tests  $tests
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tests $tests)
    {
        //
    }
}
