<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\pelanggan;
use DB;
use Auth;

class PelangganDatatable extends Datatable
{
    public $slug = 'pelanggan';

    public function datasource()
    {
        $driver = pelanggan::where('status', 1)->get(['pelanggans.id', 'nama', 'alamat', 'alias']);

        return $driver;
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

            Column::add('Alias')
                ->data('alias'),

            Column::add('Alamat')
                ->data('alamat'),
                
            Column::add()
                ->actions(function(pelanggan $pelanggan) {
                    return join([
                        Button::show('boilerplate.show-pelanggan', $pelanggan->id),
                        Button::edit('boilerplate.edit-pelanggan', $pelanggan->id),    
                        Button::delete('boilerplate.delete-pelanggan', $pelanggan->id),           
                    ]);
                }),
        ];
    }
}