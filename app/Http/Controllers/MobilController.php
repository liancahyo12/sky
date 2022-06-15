<?php

namespace App\Http\Controllers;

use App\Models\mobil;
use App\Models\jenis_paket;
use App\Models\biaya_mobil;
use App\Models\Boilerplate\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\ActivityLogger;
use Validator;
use Auth;
use DB;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::mobil.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boilerplate::mobil.create', [
            'pemilik' => User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where([['permission_id', '=', 35], ['users.active', '=', 1]])->get(['users.id', DB::raw('concat(users.first_name, " ", users.last_name) as nama')])->all(),
            'jenis_paket' => jenis_paket::where('status', 1)->get(['id', 'jenis_paket'])->all(),
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
                'pemilik'  => 'required',
                'merek'  => 'required',
                'tipe'  => 'required',
                'plat' => 'required',
            ]);

        $input['user_id'] = $request->pemilik;
        $input['merek'] = $request->merek;
        $input['tipe'] = $request->tipe;
        $input['plat'] = $request->plat;

        $last_mobil = mobil::select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $idf = $last_mobil+1;

        foreach($request->input('jenis_paket') as $key => $value) {
            $biaya["jenis_paket.{$key}"] = 'required';
            $biaya["investor.{$key}"] = 'required';
            $biaya["danlap.{$key}"] = 'required';
            $biaya["driver.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $biaya);
        if ($validator->passes()) {
            foreach($request->jenis_paket as $key => $value) {
                $biaya['biaya_investor'] = $request->investor[$key];
                $biaya['biaya_danlap'] = $request->danlap[$key];
                $biaya['biaya_driver'] = $request->driver[$key];
                $biaya['biaya'] = $request->investor[$key]+$request->danlap[$key]+$request->driver[$key];
                $biaya['jenis_paket_id'] = $value;
                $biaya['mobil_id'] = $idf;
                $biaya_mobil = biaya_mobil::create($biaya);
            }
        }

        $mobil = mobil::create($input);

        return redirect()->route('boilerplate.mobil')
                ->with('growl', [__('Mobil berhasil ditambahkan'), 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ombil  $ombil
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('boilerplate::mobil.show', [
            'pemilik' => User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where([['permission_id', '=', 35], ['users.active', '=', 1]])->get(['users.id', DB::raw('concat(users.first_name, " ", users.last_name) as nama')])->all(),
            'mobil' => mobil::where('id', $id)->first(),
            'jenis_paket' => jenis_paket::where('status', 1)->get(['id', 'jenis_paket'])->all(),
            'biaya_mobil' => biaya_mobil::where([['status' , '=', 1], ['mobil_id', '=', $id]])->get(['id', 'mobil_id', 'biaya_investor', 'biaya_danlap', 'biaya_driver', 'jenis_paket_id'])->all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ombil  $ombil
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('boilerplate::mobil.edit', [
            'pemilik' => User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where([['permission_id', '=', 35], ['users.active', '=', 1]])->get(['users.id', DB::raw('concat(users.first_name, " ", users.last_name) as nama')])->all(),
            'mobil' => mobil::where('id', $id)->first(),
            'jenis_paket' => jenis_paket::where('status', 1)->get(['id', 'jenis_paket'])->all(),
            'biaya_mobil' => biaya_mobil::where([['status' , '=', 1], ['mobil_id', '=', $id]])->get(['id', 'mobil_id', 'biaya_investor', 'biaya_danlap', 'biaya_driver', 'jenis_paket_id'])->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ombil  $ombil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = mobil::where('id', $id)->first();

        $this->validate($request, [
                'pemilik'  => 'required',
                'merek'  => 'required',
                'tipe'  => 'required',
                'plat' => 'required',
            ]);

        $input['user_id'] = $request->pemilik;
        $input['merek'] = $request->merek;
        $input['tipe'] = $request->tipe;
        $input['plat'] = $request->plat;

        foreach($request->input('jenis_paket') as $key => $value) {
            $biaya["jenis_paket.{$key}"] = 'required';
            $biaya["investor.{$key}"] = 'required';
            $biaya["danlap.{$key}"] = 'required';
            $biaya["driver.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $biaya);
        if ($validator->passes()) {
            biaya_mobil::where('mobil_id', $id)->update(['status' => 0]);
            foreach($request->jenis_paket as $key => $value) {
                $biaya['biaya_investor'] = $request->investor[$key];
                $biaya['biaya_danlap'] = $request->danlap[$key];
                $biaya['biaya_driver'] = $request->driver[$key];
                $biaya['biaya'] = $request->investor[$key]+$request->danlap[$key]+$request->driver[$key];
                $biaya['jenis_paket_id'] = $value;
                $biaya['mobil_id'] = $id;
                $biaya_mobil = biaya_mobil::create($biaya);
            }
        }
        
        $mobil = $input->save();

        return redirect()->route('boilerplate.mobil')
                ->with('growl', [__('Mobil berhasil diubah'), 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ombil  $ombil
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = mobil::where('id', $id)->first();
        $input['status'] = 0;
        $dele = $input->save();
    }

    public function nonaktif($id)
    {
        $input = mobil::where('id', $id)->first();
        $input['sedia_status'] = 4;
        $dele = $input->save();
    }
}
