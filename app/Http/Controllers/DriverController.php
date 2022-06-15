<?php

namespace App\Http\Controllers;

use App\Models\driver;
use App\Models\jenis_identitas;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::driver.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boilerplate::driver.create', [
            'jenisidentitas' => jenis_identitas::where('status', 1)->get(),
        ]);
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
                'nama'  => 'required',
                'no_identitas'  => 'required',
                'alamat' => 'required',
            ]);

        $input['jenis_identitas'] = $request->jenis_identitas;
        $input['nama'] = $request->nama;
        $input['no_identitas'] = $request->no_identitas;
        $input['alamat'] = $request->alamat;

        $driver = driver::create($input);

        return redirect()->route('boilerplate.driver')
                ->with('growl', [__('Driver berhasil ditambahkan'), 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('boilerplate::driver.show', [
            'jenisidentitas' => jenis_identitas::where('status', 1)->get(),
            'driver' => driver::where('id', $id)->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('boilerplate::driver.edit', [
            'jenisidentitas' => jenis_identitas::where('status', 1)->get(),
            'driver' => driver::where('id', $id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = driver::where('id', $id)->first();

        $this->validate($request, [
                'jenis_identitas'  => 'required',
                'nama'  => 'required',
                'no_identitas'  => 'required',
                'alamat' => 'required',
            ]);

        $input['jenis_identitas'] = $request->jenis_identitas;
        $input['nama'] = $request->nama;
        $input['no_identitas'] = $request->no_identitas;
        $input['alamat'] = $request->alamat;

        $driver = $input->save();

        return redirect()->route('boilerplate.driver')
                ->with('growl', [__('Driver berhasil diubah'), 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = driver::where('id', $id)->first();
        $input['status'] = 0;
        $driver = $input->save();
    }
}
