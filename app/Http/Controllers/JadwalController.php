<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\mobil;
use Illuminate\Http\Request;
use DB;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::booking.jadwal', [
            'mobil' => mobil::where([['status', '=', 1]])->get(['id', DB::raw('concat(merek, " ", tipe, " ", plat) as mobil')])->all(),
        ]);
    }

    public function get_jadwal(Request $request)
    {
        $events = booking::leftJoin('mobils', 'mobils.id', 'bookings.mobil_id')->whereRaw('bookings.status=1 and ((DATE_FORMAT(awal_sewa, "%Y-%m-%dT%T") between ? and ?) or (DATE_FORMAT(akhir_sewa, "%Y-%m-%dT%T") between ? and ?))', [$request->start, $request->end, $request->start, $request->end])->get([DB::raw('concat(mobils.tipe, " ",mobils.plat) as title'), DB::raw('DATE_FORMAT(awal_sewa, "%Y-%m-%dT%T") AS start'), DB::raw('DATE_FORMAT(akhir_sewa, "%Y-%m-%dT%T") AS end'), DB::raw('concat("/show-booking/", bookings.id) as url')])->all();

        return response()->json($events
        );
    }

    public function get_jadwal_mobil(Request $request)
    {
        if ($request->mobil_id > 0) {
            $events = booking::leftJoin('mobils', 'mobils.id', 'bookings.mobil_id')->whereRaw('bookings.status=1 and bookings.booking_status!=4 and mobil_id=? and ((DATE_FORMAT(awal_sewa, "%Y-%m-%dT%T") between ? and ?) or (DATE_FORMAT(akhir_sewa, "%Y-%m-%dT%T") between ? and ?))', [$request->mobil_id, $request->start, $request->end, $request->start, $request->end])->get([DB::raw('concat(mobils.tipe, " ",mobils.plat) as title'), DB::raw('concat(LEFT(awal_sewa, 10), "T",RIGHT(awal_sewa,8)) AS start'), DB::raw('concat(LEFT(akhir_sewa, 10), "T",RIGHT(akhir_sewa,8)) AS end'), DB::raw('concat("/show-booking/", bookings.id) as url'), DB::raw('if(booking_status=1, "#17A2B8", if(booking_status=2, "#6C757D",if(booking_status=3, "#28A745", "#DC3545"))) as color')])->all();
            return response()->json($events
        );
        }else {
            $events = booking::leftJoin('mobils', 'mobils.id', 'bookings.mobil_id')->whereRaw('bookings.status=1 and bookings.booking_status!=4 and ((DATE_FORMAT(awal_sewa, "%Y-%m-%dT%T") between ? and ?) or (DATE_FORMAT(akhir_sewa, "%Y-%m-%dT%T") between ? and ?))', [$request->start, $request->end, $request->start, $request->end])->get([DB::raw('concat(mobils.tipe, " ",mobils.plat) as title'), DB::raw('DATE_FORMAT(awal_sewa, "%Y-%m-%dT%T") AS start'), DB::raw('DATE_FORMAT(akhir_sewa, "%Y-%m-%dT%T") AS end'), DB::raw('concat("/show-booking/", bookings.id) as url'), DB::raw('if(booking_status=1, "#17A2B8", if(booking_status=2, "#6C757D",if(booking_status=3, "#28A745", "#DC3545"))) as color')])->all();
            return response()->json($events
        );
        }
        

        
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(booking $booking)
    {
        //
    }
}
