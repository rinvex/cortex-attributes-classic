<?php

declare(strict_types=1);

namespace Cortex\Attributable\Providers;

use Illuminate\Support\AggregateServiceProvider as BaseAggregateServiceProvider;
use Rinvex\Attributable\Providers\AttributableServiceProvider as BaseAttributableServiceProvider;

class AggregateServiceProvider extends BaseAggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        BaseAttributableServiceProvider::class,
        AttributableServiceProvider::class,
    ];
}
