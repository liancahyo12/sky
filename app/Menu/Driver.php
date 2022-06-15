<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Driver
{
    public function make(Builder $menu)
    {
        $menu->add('Driver', [
            'route' => 'boilerplate.driver',
            'active' => 'boilerplate.driver,boilerplate.edit-driver,boilerplate.show-driver,boilerplate.buat-driver',
            'permission' => 'lihat_driver',
            'icon' => 'id-card',
            'order' => 1002,
        ]);
    }
}
