<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jenis_identitas;

class JenisIdentitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::jenisidentitas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boilerplate::jenisidentitas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $this->validate($request, [
                'jenis_identitas'  => 'required',
            ]);

        $input['jenis_identitas'] = $request->jenis_identitas;

        $jenisidentitas = jenis_identitas::create($input);

        return redirect()->route('boilerplate.jenisidentitas')
                ->with('growl', [__('Jenis Identitas berhasil ditambahkan'), 'success']);
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
        return view('boilerplate::jenisidentitas.edit', [
            'jenis_identitas' => jenis_identitas::where([['id', '=', $id], ['status', '=', 1]])->first(),
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
        $input = jenis_identitas::where('id', $id)->first();

        $this->validate($request, [
                'jenis_identitas'  => 'required',
            ]);

        $input['jenis_identitas'] = $request->jenis_identitas;

        $jenisidentitas = $input->save();

        return redirect()->route('boilerplate.jenisidentitas')
                ->with('growl', [__('Jenis Identitas berhasil diubah'), 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\jenis_paket  $jenis_paket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = jenis_identitas::where('id', $id)->first();
        $input['status'] = 0;
        $driver = $input->save();
    }
}
