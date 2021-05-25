<?php

declare(strict_types=1);

use Diglactic\Breadcrumbs\Generator;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Cortex\Attributes\Models\Attribute;

Breadcrumbs::for('adminarea.cortex.attributes.attributes.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/attributes::common.attributes'), route('adminarea.cortex.attributes.attributes.index'));
});

Breadcrumbs::for('adminarea.cortex.attributes.attributes.import', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.attributes.attributes.index');
    $breadcrumbs->push(trans('cortex/attributes::common.import'), route('adminarea.cortex.attributes.attributes.import'));
});

Breadcrumbs::for('adminarea.cortex.attributes.attributes.import.logs', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.attributes.attributes.index');
    $breadcrumbs->push(trans('cortex/attributes::common.import'), route('adminarea.cortex.attributes.attributes.import'));
    $breadcrumbs->push(trans('cortex/attributes::common.logs'), route('adminarea.cortex.attributes.attributes.import.logs'));
});

Breadcrumbs::for('adminarea.cortex.attributes.attributes.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.attributes.attributes.index');
    $breadcrumbs->push(trans('cortex/attributes::common.create_attribute'), route('adminarea.cortex.attributes.attributes.create'));
});

Breadcrumbs::for('adminarea.cortex.attributes.attributes.edit', function (Generator $breadcrumbs, Attribute $attribute) {
    $breadcrumbs->parent('adminarea.cortex.attributes.attributes.index');
    $breadcrumbs->push(strip_tags($attribute->name), route('adminarea.cortex.attributes.attributes.edit', ['attribute' => $attribute]));
});

Breadcrumbs::for('adminarea.cortex.attributes.attributes.logs', function (Generator $breadcrumbs, Attribute $attribute) {
    $breadcrumbs->parent('adminarea.cortex.attributes.attributes.index');
    $breadcrumbs->push(strip_tags($attribute->name), route('adminarea.cortex.attributes.attributes.edit', ['attribute' => $attribute]));
    $breadcrumbs->push(trans('cortex/attributes::common.logs'), route('adminarea.cortex.attributes.attributes.logs', ['attribute' => $attribute]));
});
