<?php

declare(strict_types=1);

namespace Cortex\Attributes\Http\Controllers\Adminarea;

use Cortex\Attributes\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Attributes\DataTables\Adminarea\AttributesDataTable;
use Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest;

class AttributesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Attribute::class;

    /**
     * List all attributes.
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
     * List attribute logs.
     *
     * @param \Cortex\Attributes\Models\Attribute         $attribute
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Attribute $attribute, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $attribute,
            'tabs' => 'adminarea.attributes.tabs',
            'phrase' => trans('cortex/attributes::common.attributes'),
            'id' => "adminarea-attributes-{$attribute->getRouteKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Import attributes.
     *
     * @return \Illuminate\View\View
     */
    public function import()
    {
        return view('cortex/foundation::adminarea.pages.import', [
            'id' => 'adminarea-attributes-import',
            'tabs' => 'adminarea.attributes.tabs',
            'url' => route('adminarea.attributes.hoard'),
            'phrase' => trans('cortex/attributes::common.attributes'),
        ]);
    }

    /**
     * Hoard attributes.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function hoard(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * List attribute import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => 'attribute',
            'tabs' => 'adminarea.attributes.tabs',
            'id' => 'adminarea-attributes-import-logs-table',
            'phrase' => trans('cortex/attributes::common.attributes'),
        ])->render('cortex/foundation::adminarea.pages.datatable-import-logs');
    }

    /**
     * Create new attribute.
     *
     * @param \Cortex\Attributes\Models\Attribute $attribute
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

        asort($types);
        asort($groups);
        asort($entities);

        return view('cortex/attributes::adminarea.pages.attribute', compact('attribute', 'groups', 'entities', 'types'));
    }

    /**
     * Store new attribute.
     *
     * @param \Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest $request
     * @param \Cortex\Attributes\Models\Attribute                             $attribute
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(AttributeFormRequest $request, Attribute $attribute)
    {
        return $this->process($request, $attribute);
    }

    /**
     * Update given attribute.
     *
     * @param \Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest $request
     * @param \Cortex\Attributes\Models\Attribute                             $attribute
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(AttributeFormRequest $request, Attribute $attribute)
    {
        return $this->process($request, $attribute);
    }

    /**
     * Process stored/updated attribute.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Attributes\Models\Attribute     $attribute
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
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'attribute', 'identifier' => $attribute->name])],
        ]);
    }

    /**
     * Destroy given attribute.
     *
     * @param \Cortex\Attributes\Models\Attribute $attribute
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return intend([
            'url' => route('adminarea.attributes.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'attribute', 'identifier' => $attribute->name])],
        ]);
    }
}
