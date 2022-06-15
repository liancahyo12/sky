<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\booking;
use Auth;
use DB;

class RekapitulasiDatatable extends Datatable
{
    public $slug = 'rekapitulasi';

    public function datasource()
    {
        $booking;
        if (Auth::user()->hasPermission('lihat_semua_rekap')) {
            $booking = booking::leftJoin('mobils', 'mobils.id', 'mobil_id')->leftJoin('users', 'users.id', 'mobils.user_id')->where([['bookings.status', '=', 1], ['bookings.booking_status', '=', 3], ['bookings.status_tagihan', '=', 2]])->groupBy( DB::raw('DATE_FORMAT(awal_sewa,"%Y-%m")'), 'mobils.user_id')->orderByRaw('any_value(bookings.awal_sewa), mobils.user_id desc')->get([
                DB::raw('concat(any_value(first_name), " ", any_value(last_name)) as nama_investor'),
                DB::raw('sum(biaya_investor*hari) as biaya_investor'),
                DB::raw('sum(biaya_adm) as biaya_adm'),
                DB::raw('sum((biaya_investor*hari)-(biaya_adm*hari)) as pendapatan_bersih'),
                DB::raw('sum(biaya_danlap*hari) as biaya_danlap'),
                DB::raw('sum(biaya_driver*hari) as biaya_driver'),
                DB::raw('sum(biaya_bbmtol*hari) as biaya_bbmtol'),
                DB::raw('DATE_FORMAT(any_value(awal_sewa),"%Y-%m") as bulantahun'),
            ]);
        }else {
            $booking = booking::leftJoin('mobils', 'mobils.id', 'mobil_id')->leftJoin('users', 'users.id', 'mobils.user_id')->where([['bookings.status', '=', 1], ['bookings.booking_status', '=', 3], ['bookings.status_tagihan', '=', 2], ['users.id', '=', Auth::user()->id]])->groupBy( DB::raw('DATE_FORMAT(awal_sewa,"%Y-%m")'))->orderByRaw('any_value(bookings.awal_sewa), mobils.user_id desc')->get([
                DB::raw('concat(any_value(first_name), " ", any_value(last_name)) as nama_investor'),
                DB::raw('sum(biaya_investor*hari) as biaya_investor'),
                DB::raw('sum(biaya_adm) as biaya_adm'),
                DB::raw('sum((biaya_investor*hari)-(biaya_adm*hari)) as pendapatan_bersih'),
                DB::raw('sum(biaya_danlap*hari) as biaya_danlap'),
                DB::raw('sum(biaya_driver*hari) as biaya_driver'),
                DB::raw('sum(biaya_bbmtol*hari) as biaya_bbmtol'),
                DB::raw('DATE_FORMAT(any_value(awal_sewa),"%Y-%m") as bulantahun'),
            ]);
        }
        return $booking;
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Bulan')
                ->data('bulantahun'),
            
            Column::add('Nama Investor')
                ->data('nama_investor'),

            Column::add('Investor')
                ->data('biaya_investor'),

            Column::add('Adm 10%')
                ->data('biaya_adm'),

            Column::add('Pendapatan Bersih')
                ->data('pendapatan_bersih'),

            Column::add('Danlap')
                ->data('biaya_danlap'),
                
            Column::add('Driver')
                ->data('biaya_driver'),

            Column::add('BBM/TOL')
                ->data('biaya_bbmtol'),
        ];
    }
}