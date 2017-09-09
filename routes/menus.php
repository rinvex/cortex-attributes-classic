<?php

declare(strict_types=1);

Menu::adminareaSidebar('resources')->routeIfCan('list-attributes', 'adminarea.attributes.index', '<i class="fa fa-leaf"></i> <span>'.trans('cortex/attributes::common.attributes').'</span>');
