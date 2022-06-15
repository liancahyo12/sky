<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Rekapitulasi
{
    public function make(Builder $menu)
    {
        $menu->add('Rekapitulasi', [
            'route' => 'boilerplate.transaksi',
            'active' => 'boilerplate.transaksi,boilerplate.edit-transaksi,boilerplate.show-transaksi',
            'permission' => 'lihat_transaksi',
            'icon' => 'money-check-dollar',
            'order' => 1006,
        ]);
    }
}
