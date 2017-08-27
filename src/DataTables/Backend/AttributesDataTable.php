<?php

declare(strict_types=1);

namespace Cortex\Attributable\DataTables\Backend;

use Cortex\Foundation\DataTables\AbstractDataTable;
use Rinvex\Attributable\Contracts\AttributeContract;
use Cortex\Attributable\Transformers\Backend\AttributeTransformer;

class AttributesDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = AttributeContract::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = AttributeTransformer::class;

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = app($this->model)->query()->orderBy('group', 'ASC');

        return $this->applyScopes($query);
    }

    /**
     * Get parameters.
     *
     * @return array
     */
    protected function getParameters()
    {
        return [
            'keys' => true,
            'autoWidth' => false,
            'dom' => "<'row'<'col-sm-6'B><'col-sm-6'f>> <'row'r><'row'<'col-sm-12't>> <'row'<'col-sm-5'i><'col-sm-7'p>>",
            'buttons' => [
                ['extend' => 'create', 'text' => '<i class="fa fa-plus"></i> '.trans('cortex/foundation::common.new')], 'print', 'reset', 'reload', 'export',
                ['extend' => 'colvis', 'text' => '<i class="fa fa-columns"></i> '.trans('cortex/foundation::common.columns').' <span class="caret"/>'],
            ],
            'drawCallback' => 'function (settings) {
                var lastGroup = null;
                var api = this.api();
                var colspan = api.columns(\':visible\').count();
                var rows = api.rows({page:\'current\'}).nodes();

                api.column(\'group:name\', {page:\'current\'} ).data().each(function (rowGroup, rowIndex) {
                    if (lastGroup !== rowGroup) {
                        $(rows).eq(rowIndex).before(
                            \'<tr class="attribute-group"><td colspan="\'+colspan+\'"><strong>\'+(rowGroup ? rowGroup : "No Group")+\'</strong></td></tr>\'
                        );
     
                        lastGroup = rowGroup;
                    }
                });
            }',
        ];
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $transformer = app($this->transformer);

        return $this->datatables
            ->eloquent($this->query())
            ->setTransformer($transformer)
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
            'name' => ['title' => trans('cortex/attributable::common.name'), 'render' => '"<a href=\""+routes.route(\'backend.attributes.edit\', {attribute: full.slug})+"\">"+data+"</a>"', 'responsivePriority' => 0],
            'slug' => ['title' => trans('cortex/attributable::common.slug')],
            'type' => ['title' => trans('cortex/attributable::common.type')],
            'group' => ['title' => trans('cortex/attributable::common.group'), 'visible' => false],
            'is_collection' => ['title' => trans('cortex/attributable::common.collection')],
            'default' => ['title' => trans('cortex/attributable::common.default')],
            'created_at' => ['title' => trans('cortex/attributable::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/attributable::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
