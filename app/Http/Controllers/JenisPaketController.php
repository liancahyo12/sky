<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storejenis_paketRequest;
use App\Http\Requests\Updatejenis_paketRequest;
use Illuminate\Http\Request;
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
        return view('boilerplate::jenispaket.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boilerplate::jenispaket.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storejenis_paketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'jenis_paket'  => 'required',
            ]);

        $input['jenis_paket'] = $request->jenis_paket;

        $jenispaket = jenis_paket::create($input);

        return redirect()->route('boilerplate.jenispaket')
                ->with('growl', [__('Jenis Paket berhasil ditambahkan'), 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\jenis_paket  $jenis_paket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\jenis_paket  $jenis_paket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('boilerplate::jenispaket.edit', [
            'jenis_paket' => jenis_paket::where([['id', '=', $id], ['status', '=', 1]])->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatejenis_paketRequest  $request
     * @param  \App\Models\jenis_paket  $jenis_paket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = jenis_paket::where('id', $id)->first();

        $this->validate($request, [
                'jenis_paket'  => 'required',
            ]);

        $input['jenis_paket'] = $request->jenis_paket;

        $jenispaket = $input->save();

        return redirect()->route('boilerplate.jenispaket')
                ->with('growl', [__('Jenis Paket berhasil diubah'), 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\jenis_paket  $jenis_paket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = jenis_paket::where('id', $id)->first();
        $input['status'] = 0;
        $driver = $input->save();
    }
}
