<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\mobil;
use Carbon\Carbon;
use DB;

class MobilHariIniDatatable extends Datatable
{
    public $slug = 'mobil-hari-ini';

    public function datasource()
    {
        $date = Carbon::now()->isoFormat('Y-MM-DD');
        $mobils = mobil::leftJoin('users', 'users.id', 'mobils.user_id')->whereRaw("NOT EXISTS(
            SELECT * FROM bookings 
            WHERE mobils.id=bookings.mobil_id AND mobils.status=1 AND booking_status!=4 AND bookings.status=1 AND (
            (awal_sewa BETWEEN ? AND ?) OR 
            (akhir_sewa BETWEEN ? AND ?) OR
            (? BETWEEN awal_sewa AND akhir_sewa) OR
            (? BETWEEN awal_sewa AND akhir_sewa)))", [$date.' 00:00:00', $date.' 23:59:59', $date.' 00:00:00', $date.' 23:59:59', $date.' 00:00:00', $date.' 23:59:59'])->get(['mobils.id', DB::raw('concat(first_name, " ", last_name) as nama'), 'mobil', 'plat', 'tipe', 'merek', 'sedia_status']
            )->all();
        
        return $mobils;
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Pemilik')
                ->data('nama'),

            Column::add('Merek')
                ->data('merek'),

            Column::add('Tipe')
                ->data('tipe'),

            Column::add('Plat')
                ->data('plat'),
        ];
    }
}