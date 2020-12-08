<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;
use Cortex\Attributes\Models\Attribute;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu, Attribute $attribute) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.cms'), 40, 'fa fa-file-text-o', 'header', [], function (MenuItem $dropdown) use ($attribute) {
        $dropdown->route(['adminarea.cortex.attributes.attributes.index'], trans('cortex/attributes::common.attributes'), 10, 'fa fa-leaf')->ifCan('list', $attribute)->activateOnRoute('adminarea.cortex.attributes.attributes');
    });
});

Menu::register('adminarea.cortex.attributes.attributes.tabs', function (MenuGenerator $menu, Attribute $attribute) {
    $menu->route(['adminarea.cortex.attributes.attributes.import'], trans('cortex/attributes::common.records'))->ifCan('import', $attribute)->if(Route::is('adminarea.cortex.attributes.attributes.import*'));
    $menu->route(['adminarea.cortex.attributes.attributes.import.logs'], trans('cortex/attributes::common.logs'))->ifCan('import', $attribute)->if(Route::is('adminarea.cortex.attributes.attributes.import*'));
    $menu->route(['adminarea.cortex.attributes.attributes.create'], trans('cortex/attributes::common.details'))->ifCan('create', $attribute)->if(Route::is('adminarea.cortex.attributes.attributes.create'));
    $menu->route(['adminarea.cortex.attributes.attributes.edit', ['attribute' => $attribute]], trans('cortex/attributes::common.details'))->ifCan('update', $attribute)->if($attribute->exists);
    $menu->route(['adminarea.cortex.attributes.attributes.logs', ['attribute' => $attribute]], trans('cortex/attributes::common.logs'))->ifCan('audit', $attribute)->if($attribute->exists);
});
