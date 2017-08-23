<?php

declare(strict_types=1);

namespace Cortex\Attributable\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Cortex\Foundation\DataTables\LogsDataTable;
use Rinvex\Attributable\Contracts\AttributeContract;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Attributable\DataTables\Backend\AttributesDataTable;
use Cortex\Attributable\Http\Requests\Backend\AttributeFormRequest;

class AttributesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'attributes';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return app(AttributesDataTable::class)->with([
            'id' => 'cortex-attributable',
            'phrase' => trans('cortex/attributable::common.attributes'),
        ])->render('cortex/foundation::backend.pages.datatable');
    }

    /**
     * Display a listing of the resource logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function logs(AttributeContract $attribute)
    {
        return app(LogsDataTable::class)->with([
            'type' => 'attributes',
            'resource' => $attribute,
            'id' => 'cortex-attributable-logs',
            'phrase' => trans('cortex/attributable::common.attributes'),
        ])->render('cortex/foundation::backend.pages.datatable-logs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Attributable\Http\Requests\Backend\AttributeFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeFormRequest $request)
    {
        return $this->process($request, app('rinvex.attributable.attribute'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Attributable\Http\Requests\Backend\AttributeFormRequest $request
     * @param \Rinvex\Attributable\Contracts\AttributeContract                $attribute
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeFormRequest $request, AttributeContract $attribute)
    {
        return $this->process($request, $attribute);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Attributable\Contracts\AttributeContract $attribute
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(AttributeContract $attribute)
    {
        $attribute->delete();

        return intend([
            'url' => route('backend.attributes.index'),
            'with' => ['warning' => trans('cortex/attributable::messages.attribute.deleted', ['attributeId' => $attribute->id])],
        ]);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Attributable\Contracts\AttributeContract $attribute
     *
     * @return \Illuminate\Http\Response
     */
    public function form(AttributeContract $attribute)
    {
        $groups = app('rinvex.attributable.attribute')->distinct()->get(['group'])->pluck('group', 'group')->toArray();
        $types = array_combine(app('rinvex.attributable.types')->toArray(), app('rinvex.attributable.types')->toArray());
        $entities = array_combine(app('rinvex.attributable.entities')->toArray(), app('rinvex.attributable.entities')->toArray());

        return view('cortex/attributable::backend.forms.attribute', compact('attribute', 'groups', 'types', 'entities'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request                         $request
     * @param \Rinvex\Attributable\Contracts\AttributeContract $attribute
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
            'url' => route('backend.attributes.index'),
            'with' => ['success' => trans('cortex/attributable::messages.attribute.saved', ['attributeId' => $attribute->id])],
        ]);
    }
}
