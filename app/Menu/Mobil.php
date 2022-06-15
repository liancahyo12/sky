<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Mobil
{
    public function make(Builder $menu)
    {
        $menu->add('Mobil', [
            'route' => 'boilerplate.mobil',
            'active' => 'boilerplate.mobil,boilerplate.edit-mobil,boilerplate.show-mobil,boilerplate.buat-mobil',
            'permission' => 'lihat_mobil',
            'icon' => 'car',
            'order' => 1001,
        ]);
    }
}
