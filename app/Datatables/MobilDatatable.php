<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\mobil;
use DB;
use Auth;

class MobilDatatable extends Datatable
{
    public $slug = 'mobil';

    public function datasource()
    {
        $mobil = mobil::leftJoin('users', 'users.id', 'mobils.user_id')->where('status', 1)->orderByDesc('mobils.updated_at')->get(['mobils.id', DB::raw('concat(first_name, " ", last_name) as nama'), 'mobil', 'plat', 'tipe', 'merek', 'sedia_status']);

        return $mobil;
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            // Column::add('Status Sedia')
            //     ->data('sedia_status', function (mobil $mobil) {
            //         $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
            //         if ($mobil->sedia_status == 1) {
            //             return sprintf($badge1, 'success', __('tersedia'));
            //         }else if($mobil->sedia_status == 2){
            //             return sprintf($badge1, 'info', __('sedang digunakan'));
            //         }else if($mobil->sedia_status == 3){
            //             return sprintf($badge1, 'secondary', __('booked'));
            //         }else if($mobil->sedia_status == 4){
            //             return sprintf($badge1, 'danger', __('tidak aktif'));
            //         }
            //     }),

            Column::add('Id')
                ->data('id'),
            
            Column::add('Pemilik')
                ->data('nama'),

            Column::add('Merek')
                ->data('merek'),

            Column::add('Tipe')
                ->data('tipe'),

            Column::add('Plat')
                ->data('plat'),
                
            Column::add()
                ->actions(function(mobil $mobil) {
                    return join([
                        Button::show('boilerplate.show-mobil', $mobil->id),
                        Button::edit('boilerplate.edit-mobil', $mobil->id),    
                        Button::delete('boilerplate.delete-mobil', $mobil->id),
                    ]);
                }),
        ];
    }
}