<?php

declare(strict_types=1);

namespace Cortex\Attributable\DataTables\Backend;

use Cortex\Attributable\Models\Attribute;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Attributable\Transformers\Backend\AttributeTransformer;

class AttributesDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Attribute::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = AttributeTransformer::class;

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name' => ['title' => trans('cortex/attributable::common.name'), 'render' => '"<a href=\""+routes.route(\'backend.attributes.edit\', {attribute: full.id})+"\">"+data+"</a>"', 'responsivePriority' => 0],
            'type' => ['title' => trans('cortex/attributable::common.type')],
            'collection' => ['title' => trans('cortex/attributable::common.collection')],
            'default' => ['title' => trans('cortex/attributable::common.default')],
            'created_at' => ['title' => trans('cortex/attributable::common.created_at'), 'orderable' => false, 'searchable' => false],
            'updated_at' => ['title' => trans('cortex/attributable::common.updated_at'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
