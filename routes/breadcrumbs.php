<?php

declare(strict_types=1);

use Rinvex\Attributable\Contracts\AttributeContract;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('backend.attributes.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.backend'), route('backend.home'));
    $breadcrumbs->push(trans('cortex/attributable::common.attributes'), route('backend.attributes.index'));
});

Breadcrumbs::register('backend.attributes.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('backend.attributes.index');
    $breadcrumbs->push(trans('cortex/attributable::common.create_attribute'), route('backend.attributes.create'));
});

Breadcrumbs::register('backend.attributes.edit', function (BreadcrumbsGenerator $breadcrumbs, AttributeContract $attribute) {
    $breadcrumbs->parent('backend.attributes.index');
    $breadcrumbs->push($attribute->name, route('backend.attributes.edit', ['attribute' => $attribute]));
});

Breadcrumbs::register('backend.attributes.logs', function (BreadcrumbsGenerator $breadcrumbs, AttributeContract $attribute) {
    $breadcrumbs->parent('backend.attributes.index');
    $breadcrumbs->push($attribute->name, route('backend.attributes.edit', ['attribute' => $attribute]));
    $breadcrumbs->push(trans('cortex/attributable::common.logs'), route('backend.attributes.logs', ['attribute' => $attribute]));
});
