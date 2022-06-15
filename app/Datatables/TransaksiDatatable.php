<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\booking;
use Auth;
use DB;

class TransaksiDatatable extends Datatable
{
    public $slug = 'transaksi';

    public function datasource()
    {
        $booking;
        if (Auth::user()->hasPermission('lihat_semua_rekap')) {
            $booking = booking::leftjoin('pelanggans', 'pelanggans.id', 'pelanggan_id')->leftJoin('jenis_pakets', 'jenis_pakets.id', 'jenis_paket_id')->leftJoin('mobils', 'mobils.id', 'mobil_id')->leftJoin('wilayahs', 'wilayahs.kode', 'wilayah_id')->leftJoin('drivers', 'drivers.id', 'bookings.driver_id')->leftJoin('users', 'users.id', 'mobils.user_id')->where([['bookings.status', '=', 1], ['bookings.booking_status', '=', 3]])->orderByDesc('bookings.updated_at')->get([
            'bookings.id', 
            'pelanggans.nama', 
            DB::raw('concat(first_name, " ", last_name) as nama_investor'),
            DB::raw('concat(tipe, " ", plat) as mobil'),
            'jenis_paket',
            'awal_sewa',
            'akhir_sewa',
            'drivers.nama as driver',
            'wilayahs.nama as wilayah',
            'noinvoice',
            DB::raw('biaya_investor*hari as biaya_investor'),
            DB::raw('biaya_danlap*hari as biaya_danlap'),
            DB::raw('biaya_driver*hari as biaya_driver'),
            DB::raw('biaya_bbmtol*hari as biaya_bbmtol'),
            'status_tagihan',
            'booking_status',
            ]);
        }else {
            $booking = booking::leftjoin('pelanggans', 'pelanggans.id', 'pelanggan_id')->leftJoin('jenis_pakets', 'jenis_pakets.id', 'jenis_paket_id')->leftJoin('mobils', 'mobils.id', 'mobil_id')->leftJoin('wilayahs', 'wilayahs.kode', 'wilayah_id')->leftJoin('drivers', 'drivers.id', 'bookings.driver_id')->leftJoin('users', 'users.id', 'mobils.user_id')->where([['bookings.status', '=', 1], ['bookings.booking_status', '=', 3], ['users.id', '=', Auth::user()->id]])->orderByDesc('bookings.updated_at')->get([
                'bookings.id', 
                'pelanggans.nama', 
                DB::raw('concat(first_name, " ", last_name) as nama_investor'),
                DB::raw('concat(tipe, " ", plat) as mobil'),
                'jenis_paket',
                'awal_sewa',
                'akhir_sewa',
                'drivers.nama as driver',
                'wilayahs.nama as wilayah',
                'noinvoice',
                DB::raw('biaya_investor*hari as biaya_investor'),
                DB::raw('biaya_danlap*hari as biaya_danlap'),
                DB::raw('biaya_driver*hari as biaya_driver'),
                DB::raw('biaya_bbmtol*hari as biaya_bbmtol'),
                'status_tagihan',
                'booking_status',
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
            Column::add('Status')
                ->data('booking_status', function (booking $booking) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span><br>';
                    $badge2 = '<span class="badge badge-pill badge-%s">%s</span>';
                    $a;
                    $b;
                    if ($booking->booking_status == 1) {
                        $a= sprintf($badge1, 'info', __('book'));
                    }else if($booking->booking_status == 2){
                        $a= sprintf($badge1, 'secondary', __('sedang berjalan'));
                    }else if($booking->booking_status == 3){
                        $a= sprintf($badge1, 'success', __('selesai'));
                    }else if($booking->booking_status == 4){
                        $a= sprintf($badge1, 'danger', __('batal'));
                    }

                    if ($booking->status_tagihan == 1) {
                        $b= sprintf($badge2, 'info', __('belum dibayar'));
                    }else if($booking->status_tagihan == 2){
                        $b= sprintf($badge2, 'success', __('Lunas'));
                    }else if($booking->status_tagihan == 3){
                        $b= sprintf($badge2, 'warning', __('Dibayar sebagian'));
                    }else {
                        $b= sprintf($badge2, 'secondary', __('tagihan blm dibuat'));
                    }
                    return join([$a, $b]);
                }),

            Column::add('No Invoice')
                ->data('noinvoice'),
            
            Column::add('Nama Investor')
                ->data('nama_investor'),

            Column::add('Pelanggan')
                ->data('nama'),

            Column::add('Investor')
                ->data('biaya_investor'),

            Column::add('Danlap')
                ->data('biaya_danlap'),
                
            Column::add('Driver')
                ->data('biaya_driver'),

            Column::add('BBM/TOL')
                ->data('biaya_bbmtol'),

            Column::add('Mobil')
                ->data('mobil'),

            Column::add('Nama Driver')
                ->data('driver'),

            Column::add('Jenis Paket')
                ->data('jenis_paket'),

            Column::add('Wilayah')
                ->data('wilayah'),

            Column::add('Waktu Booking')
                ->data('waktu_booking', function (booking $booking) {
                    $badge1 = '<span class="badge badge-pill badge-info">awal sewa</span> '.$booking->awal_sewa.'<br>'.'<span class="badge badge-pill badge-success">akhir sewa</span> '.$booking->akhir_sewa;
                    return sprintf($badge1);
                }),
        ];
    }
}