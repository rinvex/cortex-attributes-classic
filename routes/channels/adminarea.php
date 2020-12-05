<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;

Broadcast::channel('adminarea-attributes-index', function (Authorizable $user) {
    return $user->can('list', app('rinvex.attributes.attribute'));
}, ['guards' => ['admin']]);
