<?php

declare(strict_types=1);

use Rinvex\Attributable\Contracts\AttributeContract;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.attributes.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/attributable::common.attributes'), route('adminarea.attributes.index'));
});

Breadcrumbs::register('adminarea.attributes.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push(trans('cortex/attributable::common.create_attribute'), route('adminarea.attributes.create'));
});

Breadcrumbs::register('adminarea.attributes.edit', function (BreadcrumbsGenerator $breadcrumbs, AttributeContract $attribute) {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push($attribute->name, route('adminarea.attributes.edit', ['attribute' => $attribute]));
});

Breadcrumbs::register('adminarea.attributes.logs', function (BreadcrumbsGenerator $breadcrumbs, AttributeContract $attribute) {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push($attribute->name, route('adminarea.attributes.edit', ['attribute' => $attribute]));
    $breadcrumbs->push(trans('cortex/attributable::common.logs'), route('adminarea.attributes.logs', ['attribute' => $attribute]));
});
