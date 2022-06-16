<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\jenis_identitas;

class JenisidentitasDatatable extends Datatable
{
    public $slug = 'jenisidentitas';

    public function datasource()
    {
        $jenisidentitas = jenis_identitas::where('status', 1)->orderByDesc('updated_at')->get(['id', 'jenis_identitas']);

        return $jenisidentitas;
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
            
            Column::add('Jenis Identitas')
                ->data('jenis_identitas'),
                
            Column::add('Aksi')
                ->actions(function(jenis_identitas $jenis_identitas) {
                    return join([
                        Button::edit('boilerplate.edit-jenisidentitas', $jenis_identitas->id),    
                        Button::delete('boilerplate.delete-jenisidentitas', $jenis_identitas->id),           
                    ]);
                }),
        ];
    }
}