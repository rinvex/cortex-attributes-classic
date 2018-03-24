<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;
use Cortex\Attributes\Models\Attribute;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu, Attribute $attribute) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.cms'), 40, 'fa fa-file-text-o', [], function (MenuItem $dropdown) use ($attribute) {
        $dropdown->route(['adminarea.attributes.index'], trans('cortex/attributes::common.attributes'), 10, 'fa fa-leaf')->ifCan('list', $attribute)->activateOnRoute('adminarea.attributes');
    });
});

Menu::register('adminarea.attributes.tabs', function (MenuGenerator $menu, Attribute $attribute) {
    $menu->route(['adminarea.attributes.import'], trans('cortex/attributes::common.file'))->ifCan('import', $attribute)->if(Route::is('adminarea.attributes.import*'));
    $menu->route(['adminarea.attributes.import.logs'], trans('cortex/attributes::common.logs'))->ifCan('import', $attribute)->if(Route::is('adminarea.attributes.import*'));
    $menu->route(['adminarea.attributes.create'], trans('cortex/attributes::common.details'))->ifCan('create', $attribute)->if(Route::is('adminarea.attributes.create'));
    $menu->route(['adminarea.attributes.edit', ['attribute' => $attribute]], trans('cortex/attributes::common.details'))->ifCan('update', $attribute)->if($attribute->exists);
    $menu->route(['adminarea.attributes.logs', ['attribute' => $attribute]], trans('cortex/attributes::common.logs'))->ifCan('audit', $attribute)->if($attribute->exists);
});
