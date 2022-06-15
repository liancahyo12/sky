<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoretagihanRequest;
use App\Http\Requests\UpdatetagihanRequest;
use App\Models\tagihan;
use App\Models\booking;
use DB;
use Auth;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getRomawi($bulan){
        switch ($bulan){
            case 1: 
                return "I";
            break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
    
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
     * @param  \App\Http\Requests\StoretagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $booking = booking::where([['status', '=', 1], ['id', '=', 1]])->get()->first();
        if ($booking->status_tagihan==null) {
            $tagihan['booking_id'] => $id;
            $tagihan['biaya'] => $booking->biaya;
            $tagihan['biaya_investor'] => $booking->biaya_investor;
            $tagihan['biaya_danlap'] => $booking->biaya_danlap;
            $tagihan['biaya_driver'] => $booking->biaya_driver;
            $tagihan['biaya_bbmtol'] => $booking->biaya_bbmtol;
            $tagihan['sisa_biaya'] => $booking->biaya;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(tagihan $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(tagihan $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatetagihanRequest  $request
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatetagihanRequest $request, tagihan $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(tagihan $tagihan)
    {
        //
    }
}
