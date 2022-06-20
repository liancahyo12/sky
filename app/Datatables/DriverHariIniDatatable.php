<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\driver;
use Carbon\Carbon;
use DB;

class DriverHariIniDatatable extends Datatable
{
    public $slug = 'driver-hari-ini';

    public function datasource()
    {
        $date = Carbon::now()->isoFormat('Y-MM-DD');
        $drivers = driver::whereRaw("NOT EXISTS(
            SELECT * FROM bookings 
            WHERE drivers.id=bookings.driver_id AND drivers.status=1 AND booking_status!=4 AND bookings.status=1 AND (
            (awal_sewa BETWEEN ? AND ?) OR
            (akhir_sewa BETWEEN ? AND ?) OR
            (? BETWEEN awal_sewa AND akhir_sewa) OR
            (? BETWEEN awal_sewa AND akhir_sewa)))", [$date.' 00:00:00', $date.' 23:59:59', $date.' 00:00:00', $date.' 23:59:59', $date.' 00:00:00', $date.' 23:59:59'])->get(['drivers.id', 'nama', 'alamat', 'sedia_status']
            )->all();
        
        return $drivers;
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Id')
                ->width('50px')
                ->data('id'),
            
            Column::add('Nama')
                ->data('nama'),

            Column::add('Alamat')
                ->data('alamat'),
        ];
    }
}