<?php

declare(strict_types=1);

use Cortex\Attributes\Models\Attribute;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.cortex.attributes.attributes.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/attributes::common.attributes'), route('adminarea.cortex.attributes.attributes.index'));
});

Breadcrumbs::register('adminarea.cortex.attributes.attributes.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.attributes.attributes.index');
    $breadcrumbs->push(trans('cortex/attributes::common.import'), route('adminarea.cortex.attributes.attributes.import'));
});

Breadcrumbs::register('adminarea.cortex.attributes.attributes.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.attributes.attributes.index');
    $breadcrumbs->push(trans('cortex/attributes::common.import'), route('adminarea.cortex.attributes.attributes.import'));
    $breadcrumbs->push(trans('cortex/attributes::common.logs'), route('adminarea.cortex.attributes.attributes.import.logs'));
});

Breadcrumbs::register('adminarea.cortex.attributes.attributes.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.attributes.attributes.index');
    $breadcrumbs->push(trans('cortex/attributes::common.create_attribute'), route('adminarea.cortex.attributes.attributes.create'));
});

Breadcrumbs::register('adminarea.cortex.attributes.attributes.edit', function (BreadcrumbsGenerator $breadcrumbs, Attribute $attribute) {
    $breadcrumbs->parent('adminarea.cortex.attributes.attributes.index');
    $breadcrumbs->push(strip_tags($attribute->name), route('adminarea.cortex.attributes.attributes.edit', ['attribute' => $attribute]));
});

Breadcrumbs::register('adminarea.cortex.attributes.attributes.logs', function (BreadcrumbsGenerator $breadcrumbs, Attribute $attribute) {
    $breadcrumbs->parent('adminarea.cortex.attributes.attributes.index');
    $breadcrumbs->push(strip_tags($attribute->name), route('adminarea.cortex.attributes.attributes.edit', ['attribute' => $attribute]));
    $breadcrumbs->push(trans('cortex/attributes::common.logs'), route('adminarea.cortex.attributes.attributes.logs', ['attribute' => $attribute]));
});
