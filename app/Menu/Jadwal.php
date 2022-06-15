<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Jadwal
{
    public function make(Builder $menu)
    {
        $menu->add('Jadwal', [
            'route' => 'boilerplate.jadwal',
            'active' => 'boilerplate.jadwal',
            'permission' => 'lihat_jadwal',
            'icon' => 'calendar-days',
            'order' => 1005,
        ]);
    }
}
