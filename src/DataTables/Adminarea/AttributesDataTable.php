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
    protected $builderParameters = [
        'rowGroup' => '{
            dataSrc: \'group\'
        }',
    ];

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $locale = app()->getLocale();
        $query = app($this->model)->query()->orderBy('group', 'ASC')->orderBy('sort_order', 'ASC')->orderBy("name->\${$locale}", 'ASC');

        return $this->applyScopes($query);
    }

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
            'name' => ['title' => trans('cortex/attributes::common.name'), 'render' => $link, 'responsivePriority' => 0],
            'type' => ['title' => trans('cortex/attributes::common.type'), 'render' => 'Lang.trans(\'cortex/attributes::common.\'+data)'],
            'group' => ['title' => trans('cortex/attributes::common.group'), 'visible' => false],
            'is_collection' => ['title' => trans('cortex/attributes::common.is_collection')],
            'is_required' => ['title' => trans('cortex/attributes::common.is_required')],
            'created_at' => ['title' => trans('cortex/attributes::common.created_at'), 'render' => "moment(data).format('MMMM Do YYYY, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/attributes::common.updated_at'), 'render' => "moment(data).format('MMMM Do YYYY, hh:mm:ss A')"],
        ];
    }
}
