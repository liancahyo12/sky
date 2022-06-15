<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Pelanggan
{
    public function make(Builder $menu)
    {
        $menu->add('Pelanggan', [
            'route' => 'boilerplate.pelanggan',
            'active' => 'boilerplate.pelanggan,boilerplate.edit-pelanggan,boilerplate.show-pelanggan,boilerplate.buat-pelanggan',
            'permission' => 'lihat_pelanggan',
            'icon' => 'users',
            'order' => 1003,
        ]);
    }
}
