<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\booking;
use DB;
use Auth;

class BookingDatatable extends Datatable
{
    public $slug = 'booking';

    public function datasource()
    {
        $booking = booking::leftjoin('pelanggans', 'pelanggans.id', 'pelanggan_id')->leftJoin('jenis_pakets', 'jenis_pakets.id', 'jenis_paket_id')->leftJoin('mobils', 'mobils.id', 'mobil_id')->leftJoin('wilayahs', 'wilayahs.kode', 'wilayah_id')->where('bookings.status', 1)->orderByDesc('bookings.updated_at')->get([
            'bookings.id', 
            'pelanggans.nama', 
            DB::raw('concat(tipe, " ", plat) as mobil'),
            'jenis_paket',
            'awal_sewa',
            'akhir_sewa',
            'wilayahs.nama as wilayah',
            'noinvoice',
            'status_tagihan',
            'booking_status',
        ]);

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

            Column::add('No Tagihan')
                ->data('noinvoice'),
            
            Column::add('Pelanggan')
                ->data('nama'),

            Column::add('Mobil')
                ->data('mobil'),

            Column::add('Jenis Paket')
                ->data('jenis_paket'),

            Column::add('Wilayah')
                ->data('wilayah'),

            Column::add('Waktu Booking')
                ->data('waktu_booking', function (booking $booking) {
                    $badge1 = '<span class="badge badge-pill badge-info">awal sewa</span> '.$booking->awal_sewa.'<br>'.'<span class="badge badge-pill badge-success">akhir sewa</span> '.$booking->akhir_sewa;
                    return sprintf($badge1);
                }),
            Column::add('Aksi')
                ->width('40px')
                ->actions(function(booking $booking) {
                    $show='';
                    $edit='';
                    $delete='';
                    $batal='';
                    $ctagihan='';
                    if (Auth::user()->hasPermission('show_booking')) {
                        $show = Button::show('boilerplate.show-booking', $booking->id);
                    }
                    if (Auth::user()->hasPermission('edit_booking')) {
                        $edit = Button::edit('boilerplate.edit-booking', $booking->id);
                    }
                    if (Auth::user()->hasPermission('hapus_booking')) {
                        $delete = Button::delete('boilerplate.delete-booking', $booking->id);
                    }
                    // if (Auth::user()->hasPermission('buat_tagihan')) {
                    //     $ctagihan = '<br>'.Button::add('Buat Tagihan')->route('boilerplate.store-tagihan', $booking->id)->color('primary')->make();
                    // }
                    if ($booking->booking_status==1 && $booking->booking_status!=4) {
                        if (Auth::user()->hasPermission('batal_booking')) {
                            $batal = '<br>'.Button::add('Batal Booking')->route('boilerplate.batal-booking', $booking->id)->color('danger')->attributes(['data-action' => 'batal'])->make();
                        }
                    }
                    return join([$show, $edit, $delete, $batal, $ctagihan]);
                }),
        ];
    }
}