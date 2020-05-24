<?php

declare(strict_types=1);

Broadcast::channel('adminarea-attributes-index', function ($user) {
    return $user->can('list', app('rinvex.attributes.attribute'));
}, ['guards' => ['admin']]);
