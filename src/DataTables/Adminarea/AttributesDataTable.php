<?php

declare(strict_types=1);

namespace Cortex\Attributes\DataTables\Adminarea;

use Rinvex\Attributes\Models\Attribute;
use Cortex\Foundation\DataTables\AbstractDataTable;

class AttributesDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Attribute::class;

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
     * Get default builder parameters.
     *
     * @return array
     */
    protected function getBuilderParameters(): array
    {
        return [
            'keys' => true,
            'retrieve' => true,
            'autoWidth' => false,
            'dom' => "<'row'<'col-sm-6'B><'col-sm-6'f>> <'row'r><'row'<'col-sm-12't>> <'row'<'col-sm-5'i><'col-sm-7'p>>",
            'buttons' => [
                ['extend' => 'create', 'text' => '<i class="fa fa-plus"></i> '.trans('cortex/foundation::common.new')], 'print', 'reset', 'reload', 'export',
                ['extend' => 'colvis', 'text' => '<i class="fa fa-columns"></i> '.trans('cortex/foundation::common.columns').' <span class="caret"/>'],
                ['extend' => 'pageLength', 'text' => '<i class="fa fa-list-ol"></i> '.trans('cortex/foundation::common.limit').' <span class="caret"/>'],
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
        return datatables($this->query())
            ->orderColumn('name', 'name->"$.'.app()->getLocale().'" $1')
            ->make(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.attributes.edit\', {attribute: full.slug, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.attributes.edit\', {attribute: full.slug})+"\">"+data+"</a>"';

        return [
            'name' => ['title' => trans('cortex/attributes::common.name'), 'render' => $link, 'responsivePriority' => 0],
            'slug' => ['title' => trans('cortex/attributes::common.slug')],
            'type' => ['title' => trans('cortex/attributes::common.type'), 'render' => 'Lang.trans(\'cortex/attributes::common.\'+data)'],
            'group' => ['title' => trans('cortex/attributes::common.group'), 'visible' => false],
            'is_collection' => ['title' => trans('cortex/attributes::common.collection')],
            'is_required' => ['title' => trans('cortex/attributes::common.required')],
            'created_at' => ['title' => trans('cortex/attributes::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/attributes::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
