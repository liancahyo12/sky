<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storejenis_paketRequest;
use App\Http\Requests\Updatejenis_paketRequest;
use App\Models\jenis_paket;

class JenisPaketController extends Controller
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
     * @param  \App\Http\Requests\Storejenis_paketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storejenis_paketRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\jenis_paket  $jenis_paket
     * @return \Illuminate\Http\Response
     */
    public function show(jenis_paket $jenis_paket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\jenis_paket  $jenis_paket
     * @return \Illuminate\Http\Response
     */
    public function edit(jenis_paket $jenis_paket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatejenis_paketRequest  $request
     * @param  \App\Models\jenis_paket  $jenis_paket
     * @return \Illuminate\Http\Response
     */
    public function update(Updatejenis_paketRequest $request, jenis_paket $jenis_paket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\jenis_paket  $jenis_paket
     * @return \Illuminate\Http\Response
     */
    public function destroy(jenis_paket $jenis_paket)
    {
        //
    }
}
