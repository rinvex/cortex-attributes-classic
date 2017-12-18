<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Factories\MenuFactory;

Menu::modify('adminarea.sidebar', function(MenuFactory $menu) {
    $menu->findBy('title', trans('cortex/foundation::common.cms'), function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.attributes.index'], trans('cortex/attributes::common.attributes'), 10, 'fa fa-leaf')->can('list-attributes');
    });
});
