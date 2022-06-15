<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storebiaya_mobilRequest;
use App\Http\Requests\Updatebiaya_mobilRequest;
use App\Models\biaya_mobil;

class BiayaMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\Storebiaya_mobilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storebiaya_mobilRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\biaya_mobil  $biaya_mobil
     * @return \Illuminate\Http\Response
     */
    public function show(biaya_mobil $biaya_mobil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\biaya_mobil  $biaya_mobil
     * @return \Illuminate\Http\Response
     */
    public function edit(biaya_mobil $biaya_mobil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatebiaya_mobilRequest  $request
     * @param  \App\Models\biaya_mobil  $biaya_mobil
     * @return \Illuminate\Http\Response
     */
    public function update(Updatebiaya_mobilRequest $request, biaya_mobil $biaya_mobil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\biaya_mobil  $biaya_mobil
     * @return \Illuminate\Http\Response
     */
    public function destroy(biaya_mobil $biaya_mobil)
    {
        //
    }
}
