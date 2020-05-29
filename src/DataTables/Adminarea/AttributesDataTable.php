<?php

declare(strict_types=1);

namespace Cortex\Attributes\DataTables\Adminarea;

use Cortex\Attributes\Models\Attribute;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Attributes\Transformers\Adminarea\AttributeTransformer;

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
     * {@inheritdoc}
     */
    protected $order = [
        [1, 'asc'],
        [0, 'asc'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $builderParameters = [
        'rowGroup' => '{
            dataSrc: \'group\'
        }',
    ];

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.attributes.edit\', {attribute: full.id, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.attributes.edit\', {attribute: full.id})+"\">"+data+"</a>"';

        return [
            'id' => ['checkboxes' => '{"selectRow": true}', 'exportable' => false, 'printable' => false],
            'name' => ['title' => trans('cortex/attributes::common.name'), 'render' => $link, 'responsivePriority' => 0],
            'type' => ['title' => trans('cortex/attributes::common.type'), 'render' => 'Lang.trans(\'cortex/attributes::common.\'+data)'],
            'group' => ['title' => trans('cortex/attributes::common.group'), 'visible' => false],
            'is_collection' => ['title' => trans('cortex/attributes::common.is_collection')],
            'is_required' => ['title' => trans('cortex/attributes::common.is_required')],
            'created_at' => ['title' => trans('cortex/attributes::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/attributes::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }
}
