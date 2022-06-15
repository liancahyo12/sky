<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Booking
{
    public function make(Builder $menu)
    {
        $menu->add('Booking', [
            'route' => 'boilerplate.booking',
            'active' => 'boilerplate.booking,boilerplate.edit-booking,boilerplate.show-booking,boilerplate.buat-booking',
            'permission' => 'lihat_booking',
            'icon' => 'calendar-check',
            'order' => 1004,
        ]);
    }
}
