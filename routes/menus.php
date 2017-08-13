<?php

declare(strict_types=1);

Menu::backendSidebar('resources')->routeIfCan('list-attributes', 'backend.attributes.index', '<i class="fa fa-leaf"></i> <span>'.trans('cortex/attributable::common.attributes').'</span>');
