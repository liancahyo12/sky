<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\driver;
use DB;
use Auth;

class DriverDatatable extends Datatable
{
    public $slug = 'driver';

    public function datasource()
    {
        $driver = driver::where('status', 1)->orderByDesc('drivers.updated_at')->get(['drivers.id', 'nama', 'alamat', 'sedia_status']);

        return $driver;
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            // Column::add('Status Sedia')
            //     ->width('120px')
            //     ->data('sedia_status', function (driver $driver) {
            //         $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
            //         if ($driver->sedia_status == 1) {
            //             return sprintf($badge1, 'success', __('tersedia'));
            //         }else if($driver->sedia_status == 2){
            //             return sprintf($badge1, 'info', __('sedang digunakan'));
            //         }else if($driver->sedia_status == 3){
            //             return sprintf($badge1, 'secondary', __('booked'));
            //         }else if($driver->sedia_status == 4){
            //             return sprintf($badge1, 'danger', __('tidak aktif'));
            //         }
            //     }),

            Column::add('Id')
                ->width('50px')
                ->data('id'),
            
            Column::add('Nama')
                ->data('nama'),

            Column::add('Alamat')
                ->data('alamat'),
                
            Column::add()
                ->actions(function(driver $driver) {
                    return join([
                        Button::show('boilerplate.show-driver', $driver->id),
                        Button::edit('boilerplate.edit-driver', $driver->id),    
                        Button::delete('boilerplate.delete-driver', $driver->id),           
                    ]);
                }),
        ];
    }
}