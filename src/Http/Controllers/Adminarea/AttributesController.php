<?php

declare(strict_types=1);

namespace Cortex\Attributes\Http\Controllers\Adminarea;

use Rinvex\Attributes\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Attributes\DataTables\Adminarea\AttributesDataTable;
use Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest;

class AttributesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'attribute';

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
            'id' => 'adminarea-attributes-index-table',
            'phrase' => trans('cortex/attributes::common.attributes'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * Get a listing of the resource logs.
     *
     * @param \Rinvex\Attributes\Models\Attribute $attribute
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Attribute $attribute, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $attribute,
            'tabs' => 'adminarea.attributes.tabs',
            'phrase' => trans('cortex/attributes::common.attributes'),
            'id' => "adminarea-attributes-{$attribute->getKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Attributes\Models\Attribute $attribute
     *
     * @return \Illuminate\View\View
     */
    public function create(Attribute $attribute)
    {
        return $this->form($attribute);
    }

    /**
     * Edit given attribute.
     *
     * @param \Cortex\Attributes\Models\Attribute $attribute
     *
     * @return \Illuminate\View\View
     */
    public function edit(Attribute $attribute)
    {
        return $this->form($attribute);
    }

    /**
     * Show attribute create/edit form.
     *
     * @param \Cortex\Attributes\Models\Attribute $attribute
     *
     * @return \Illuminate\View\View
     */
    protected function form(Attribute $attribute)
    {
        $groups = app('rinvex.attributes.attribute')->distinct()->get(['group'])->pluck('group', 'group')->toArray();
        $entities = array_combine(app('rinvex.attributes.entities')->toArray(), app('rinvex.attributes.entities')->toArray());
        $types = array_combine($typeKeys = array_keys(Attribute::typeMap()), array_map(function ($item) {
            return trans('cortex/attributes::common.'.$item);
        }, $typeKeys));

        ksort($types);
        ksort($groups);
        ksort($entities);

        return view('cortex/attributes::adminarea.pages.attribute', compact('attribute', 'groups', 'entities', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(AttributeFormRequest $request)
    {
        return $this->process($request, app('rinvex.attributes.attribute'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest $request
     * @param \Rinvex\Attributes\Models\Attribute                             $attribute
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(AttributeFormRequest $request, Attribute $attribute)
    {
        return $this->process($request, $attribute);
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Rinvex\Attributes\Models\Attribute     $attribute
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Attribute $attribute)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save attribute
        $attribute->fill($data)->save();

        return intend([
            'url' => route('adminarea.attributes.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'attribute', 'id' => $attribute->slug])],
        ]);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Attributes\Models\Attribute $attribute
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return intend([
            'url' => route('adminarea.attributes.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'attribute', 'id' => $attribute->slug])],
        ]);
    }
}
