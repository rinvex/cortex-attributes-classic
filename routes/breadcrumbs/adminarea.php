<?php

declare(strict_types=1);

use Cortex\Attributes\Models\Attribute;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.attributes.index', function (BreadcrumbsGenerator $breadcrumbs): void {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/attributes::common.attributes'), route('adminarea.attributes.index'));
});

Breadcrumbs::register('adminarea.attributes.import', function (BreadcrumbsGenerator $breadcrumbs): void {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push(trans('cortex/attributes::common.import'), route('adminarea.attributes.import'));
});

Breadcrumbs::register('adminarea.attributes.import.logs', function (BreadcrumbsGenerator $breadcrumbs): void {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push(trans('cortex/attributes::common.import'), route('adminarea.attributes.import'));
    $breadcrumbs->push(trans('cortex/attributes::common.logs'), route('adminarea.attributes.import.logs'));
});

Breadcrumbs::register('adminarea.attributes.create', function (BreadcrumbsGenerator $breadcrumbs): void {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push(trans('cortex/attributes::common.create_attribute'), route('adminarea.attributes.create'));
});

Breadcrumbs::register('adminarea.attributes.edit', function (BreadcrumbsGenerator $breadcrumbs, Attribute $attribute): void {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push($attribute->name, route('adminarea.attributes.edit', ['attribute' => $attribute]));
});

Breadcrumbs::register('adminarea.attributes.logs', function (BreadcrumbsGenerator $breadcrumbs, Attribute $attribute): void {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push($attribute->name, route('adminarea.attributes.edit', ['attribute' => $attribute]));
    $breadcrumbs->push(trans('cortex/attributes::common.logs'), route('adminarea.attributes.logs', ['attribute' => $attribute]));
});
