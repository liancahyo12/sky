<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Audittrail
{
    public function make(Builder $menu)
    {
        $menu->add('Audit Trail', [
            'route' => 'boilerplate.audit-trail',
            'active' => 'boilerplate.audit-trail',
            'permission' => 'logs',
            'icon' => 'bars-staggered',
            'order' => 1010,
        ]);
    }
}
