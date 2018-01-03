<?php

declare(strict_types=1);

namespace Cortex\Attributes\Http\Controllers\Adminarea;

use Illuminate\Http\Request;
use Rinvex\Attributes\Models\Attribute;
use Cortex\Foundation\DataTables\LogsDataTable;
use Rinvex\Attributes\Contracts\AttributeContract;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Attributes\DataTables\Adminarea\AttributesDataTable;
use Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest;

class AttributesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'attributes';

    /**
     * Display a listing of the resource.
     *
     * @param \Cortex\Attributes\DataTables\Adminarea\AttributesDataTable $attributesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(AttributesDataTable $attributesDataTable)
    {
        return $attributesDataTable->with([
            'id' => 'cortex-attributes',
            'phrase' => trans('cortex/attributes::common.attributes'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * Get a listing of the resource logs.
     *
     * @param \Rinvex\Attributes\Contracts\AttributeContract $attribute
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logs(AttributeContract $attribute)
    {
        return request()->ajax() && request()->wantsJson()
            ? app(LogsDataTable::class)->with(['resource' => $attribute])->ajax()
            : intend(['url' => route('adminarea.attributes.edit', ['attribute' => $attribute]).'#logs-tab']);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Attributes\Contracts\AttributeContract $attribute
     *
     * @return \Illuminate\Http\Response
     */
    public function form(AttributeContract $attribute)
    {
        $groups = app('rinvex.attributes.attribute')->distinct()->get(['group'])->pluck('group', 'group')->toArray();
        $entities = array_combine(app('rinvex.attributes.entities')->toArray(), app('rinvex.attributes.entities')->toArray());
        $types = array_combine($typeKeys = array_keys(Attribute::typeMap()), array_map(function ($item) {
            return trans('cortex/attributes::common.'.$item);
        }, $typeKeys));

        ksort($types);
        ksort($groups);
        ksort($entities);

        $logs = app(LogsDataTable::class)->with(['id' => 'logs-table'])->html()->minifiedAjax(route('adminarea.attributes.logs', ['attribute' => $attribute]));

        return view('cortex/attributes::adminarea.pages.attribute', compact('attribute', 'groups', 'entities', 'types', 'logs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeFormRequest $request)
    {
        return $this->process($request, app('rinvex.attributes.attribute'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest $request
     * @param \Rinvex\Attributes\Contracts\AttributeContract                  $attribute
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeFormRequest $request, AttributeContract $attribute)
    {
        return $this->process($request, $attribute);
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request                       $request
     * @param \Rinvex\Attributes\Contracts\AttributeContract $attribute
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, AttributeContract $attribute)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save attribute
        $attribute->fill($data)->save();

        return intend([
            'url' => route('adminarea.attributes.index'),
            'with' => ['success' => trans('cortex/attributes::messages.attribute.saved', ['slug' => $attribute->slug])],
        ]);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Attributes\Contracts\AttributeContract $attribute
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(AttributeContract $attribute)
    {
        $attribute->delete();

        return intend([
            'url' => route('adminarea.attributes.index'),
            'with' => ['warning' => trans('cortex/attributes::messages.attribute.deleted', ['slug' => $attribute->slug])],
        ]);
    }
}
