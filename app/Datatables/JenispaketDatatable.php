<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\jenis_paket;

class JenispaketDatatable extends Datatable
{
    public $slug = 'jenispaket';

    public function datasource()
    {
        $jenispaket = jenis_paket::where('status', 1)->orderByDesc('updated_at')->get(['id', 'jenis_paket']);

        return $jenispaket;
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
            
            Column::add('Jenis Paket')
                ->data('jenis_paket'),
                
            Column::add('Aksi')
                ->actions(function(jenis_paket $jenis_paket) {
                    return join([
                        Button::edit('boilerplate.edit-jenispaket', $jenis_paket->id),    
                        Button::delete('boilerplate.delete-jenispaket', $jenis_paket->id),           
                    ]);
                }),
        ];
    }
}