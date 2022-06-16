<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Pengaturan
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Pengaturan', [
            'icon' => 'gears',
            'permission' => 'lihat_jenisidentitas',
            'order' => 1009,
        ]);
        $item->add('Jenis Identitas', [
            'route' => 'boilerplate.jenisidentitas',
            'active' => 'boilerplate.jenisidentitas,boilerplate.edit-jenisidentitas,boilerplate.buat-jenisidentitas,boilerplate.show-jenisidentitas',
            'permission' => 'lihat_jenisidentitas',
            'order' => 100,
        ]);
        $item->add('Jenis Paket', [
            'route' => 'boilerplate.jenispaket',
            'active' => 'boilerplate.jenispaket,boilerplate.edit-jenispaket,boilerplate.buat-jenispaket,boilerplate.show-jenispaket',
            'permission' => 'lihat_jenispaket',
            'order' => 101,
        ]);
    }
}
