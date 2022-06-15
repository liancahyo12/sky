<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\pembayaran;
use Auth;

class PembayaranDatatable extends Datatable
{
    public $slug = 'pembayaran';

    public function datasource()
    {
        $pembayaran = pembayaran::leftJoin('bookings', 'bookings.id', 'booking_id')->where([['pembayarans.status', '=', 1], ['booking_id', '=', request()->post('id')]])->get([
            'pembayarans.id',
            'noinvoice', 
            'pembayaran', 
            'pembayarans.sisa_tagihan', 
            'bukti_bayar', 
            'status_pembayaran',
            'pembayarans.keterangan',
            'pembayarans.waktu_bayar',
        ]);

        return $pembayaran;
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [

            Column::add('No Tagihan')
                ->data('noinvoice'),
            
            Column::add('Pembayaran')
                ->data('pembayaran'),

            Column::add('Bukti Bayar')
                ->data('id', function (pembayaran $pembayaran) {
                    $badge1 = '<a href="/get-bukti-bayar/'.$pembayaran->id.'.jpeg" data-toggle="lightbox" data-title="Bukti Bayar '.$pembayaran->noinvoice.'" class=""><img src="/get-bukti-bayar/'.$pembayaran->id.'.jpeg" class="img-fluid mb-2" alt="bukti bayar" height=10 width=30>
                    </a>';
                    return join([$badge1]);
                }),
  
            Column::add('Waktu Bayar')
                ->data('waktu_bayar'),
                
            Column::add('Sisa Tagihan')
                ->data('sisa_tagihan'),

            Column::add('Keterangan')
                ->data('keterangan'),
                
            Column::add('Aksi')
                ->width('40px')
                ->actions(function(pembayaran $pembayaran) {
                    $edit='';
                    $delete='';
                    if (Auth::user()->hasPermission('edit_bayar')) {
                        $edit = Button::edit('boilerplate.edit-bayar-booking', $pembayaran->id);
                    }
                    // if (Auth::user()->hasPermission('delete_bayar')) {
                    //     $delete = Button::delete('boilerplate.delete-bayar-booking', $pembayaran->id);
                    // }
                    return join([$edit, $delete]);
                }),
        ];
    }
}