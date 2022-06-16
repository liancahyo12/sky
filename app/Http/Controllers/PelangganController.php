<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use App\Models\jenis_identitas;
use Illuminate\Http\Request;
use DB;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::pelanggan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('boilerplate::pelanggan.show', [
            'pelanggan' => pelanggan::where([['status', '=', 1], ['id', '=', $id]])->get([
                'id',
                'nama',
                DB::raw('concat(left(no_identitas, 2), "*******", right(no_identitas, 2)) as no_identitas'),
                'jenis_identitas_id',
                'alamat',
                'alias',
                'group',
                'kenalan',])->first(),
            'jenis_identitas' => jenis_identitas::where('status', 1)->get()->all(),
            
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('boilerplate::pelanggan.edit', [
            'pelanggan' => pelanggan::where([['status', '=', 1], ['id', '=', $id]])->get([
                'id',
                'nama',
                'no_identitas',
                'jenis_identitas_id',
                'alamat',
                'alias',
                'group',
                'kenalan',])->first(),
            'jenis_identitas' => jenis_identitas::where('status', 1)->get()->all(),
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mod/els\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pelanggan $pelanggan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(pelanggan $pelanggan)
    {
        $input = pelanggan::where('id', $id)->first();
        $input['status'] = 0;
        $dele = $input->save();
    }
}
