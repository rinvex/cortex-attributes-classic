<?php

declare(strict_types=1);

namespace Cortex\Attributes\Http\Controllers\Adminarea;

use Exception;
use Illuminate\Http\Request;
use Cortex\Attributes\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Foundation\DataTables\ImportRecordsDataTable;
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
            'id' => 'adminarea-cortex-attributes-attributes-index',
            'pusher' => ['entity' => 'attribute', 'channel' => 'rinvex.attributes.index'],
        ])->render('cortex/foundation::adminarea.pages.datatable-index');
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
            'tabs' => 'adminarea.cortex.attributes.attributes.tabs',
            'id' => "adminarea-cortex-attributes-attributes-{$attribute->getRouteKey()}-logs",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Import attributes.
     *
     * @param \Cortex\Attributes\Models\Attribute                  $attribute
     * @param \Cortex\Foundation\DataTables\ImportRecordsDataTable $importRecordsDataTable
     *
     * @return \Illuminate\View\View
     */
    public function import(Attribute $attribute, ImportRecordsDataTable $importRecordsDataTable)
    {
        return $importRecordsDataTable->with([
            'resource' => $attribute,
            'tabs' => 'adminarea.cortex.attributes.attributes.tabs',
            'url' => route('adminarea.cortex.attributes.attributes.stash'),
            'id' => "adminarea-cortex-attributes-attributes-{$attribute->getRouteKey()}-import",
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Stash attributes.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function stash(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * Hoard attributes.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function hoard(ImportFormRequest $request)
    {
        foreach ((array) $request->get('selected_ids') as $recordId) {
            $record = app('cortex.foundation.import_record')->find($recordId);

            try {
                $fillable = collect($record['data'])->intersectByKeys(array_flip(app('rinvex.attributes.attribute')->getFillable()))->toArray();

                tap(app('rinvex.attributes.attribute')->firstOrNew($fillable), function ($instance) use ($record) {
                    $instance->save() && $record->delete();
                });
            } catch (Exception $exception) {
                $record->notes = $exception->getMessage().(method_exists($exception, 'getMessageBag') ? "\n".json_encode($exception->getMessageBag())."\n\n" : '');
                $record->status = 'fail';
                $record->save();
            }
        }

        return intend([
            'back' => true,
            'with' => ['success' => trans('cortex/foundation::messages.import_complete')],
        ]);
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
            'resource' => trans('cortex/attributes::common.attribute'),
            'tabs' => 'adminarea.cortex.attributes.attributes.tabs',
            'id' => 'adminarea-cortex-attributes-attributes-import-logs',
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Create new category.
     *
     * @param \Illuminate\Http\Request            $request
     * @param \Cortex\Attributes\Models\Attribute $attribute
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, Attribute $attribute)
    {
        return $this->form($request, $attribute);
    }

    /**
     * Edit given category.
     *
     * @param \Illuminate\Http\Request            $request
     * @param \Cortex\Attributes\Models\Attribute $attribute
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Attribute $attribute)
    {
        return $this->form($request, $attribute);
    }

    /**
     * Show attribute create/edit form.
     *
     * @param \Illuminate\Http\Request            $request
     * @param \Cortex\Attributes\Models\Attribute $attribute
     *
     * @return \Illuminate\View\View
     */
    protected function form(Request $request, Attribute $attribute)
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
            'url' => route('adminarea.cortex.attributes.attributes.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/attributes::common.attribute'), 'identifier' => $attribute->getRouteKey()])],
        ]);
    }

    /**
     * Destroy given attribute.
     *
     * @param \Cortex\Attributes\Models\Attribute $attribute
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return intend([
            'url' => route('adminarea.cortex.attributes.attributes.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/attributes::common.attribute'), 'identifier' => $attribute->getRouteKey()])],
        ]);
    }
}
