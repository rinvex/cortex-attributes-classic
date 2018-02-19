<?php

declare(strict_types=1);

use Rinvex\Attributes\Models\Attribute;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.attributes.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/attributes::common.attributes'), route('adminarea.attributes.index'));
});

Breadcrumbs::register('adminarea.attributes.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push(trans('cortex/attributes::common.create_attribute'), route('adminarea.attributes.create'));
});

Breadcrumbs::register('adminarea.attributes.edit', function (BreadcrumbsGenerator $breadcrumbs, Attribute $attribute) {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push($attribute->title, route('adminarea.attributes.edit', ['attribute' => $attribute]));
});

Breadcrumbs::register('adminarea.attributes.logs', function (BreadcrumbsGenerator $breadcrumbs, Attribute $attribute) {
    $breadcrumbs->parent('adminarea.attributes.index');
    $breadcrumbs->push($attribute->title, route('adminarea.attributes.edit', ['attribute' => $attribute]));
    $breadcrumbs->push(trans('cortex/attributes::common.logs'), route('adminarea.attributes.logs', ['attribute' => $attribute]));
});
