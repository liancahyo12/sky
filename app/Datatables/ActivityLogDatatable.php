<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use DB;

class ActivityLogDatatable extends Datatable
{
    public $slug = 'activity-log';

    public function datasource()
    {
        $logs = DB::select('select description, subject_type, concat(first_name, " ", last_name) as pengguna, properties, activity_log.created_at from activity_log left join users on users.id=activity_log.causer_id');

        return $logs;
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [            
            Column::add('Deskripsi')
                ->data('description'),

            Column::add('Model')
                ->data('subject_type'),

            Column::add('Pengguna')
                ->data('pengguna'),

            Column::add('Properti')
                ->data('properties'),

            Column::add('Waktu')
                ->data('created_at'),
        ];
    }
}