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
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->setTransformer(new $this->transformer)
            ->orderColumn('name', 'name->"$.'.app()->getLocale().'" $1')
            ->make(true);
    }

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
            'created_at' => ['title' => trans('cortex/attributable::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/attributable::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
