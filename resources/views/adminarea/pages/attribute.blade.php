{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest::class)->selector("#adminarea-cortex-attributes-attributes-create-form, #adminarea-cortex-attributes-attributes-{$attribute->getRouteKey()}-update-form")->ignore('.skip-validation') !!}
@endpush

{{-- Main Content --}}
@section('content')

    @includeWhen($attribute->exists, 'cortex/foundation::adminarea.partials.modal', ['id' => 'delete-confirmation'])

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                @includeWhen($attribute->exists, 'cortex/foundation::adminarea.partials.actions', ['name' => 'attribute', 'model' => $attribute, 'resource' => trans('cortex/attributes::common.attribute'), 'routePrefix' => 'adminarea.cortex.attributes.attributes.'])
                {!! Menu::render('adminarea.cortex.attributes.attributes.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($attribute->exists)
                            {{ Form::model($attribute, ['url' => route('adminarea.cortex.attributes.attributes.update', ['attribute' => $attribute]), 'method' => 'put', 'id' => "adminarea-cortex-attributes-attributes-{$attribute->getRouteKey()}-update-form"]) }}
                        @else
                            {{ Form::model($attribute, ['url' => route('adminarea.cortex.attributes.attributes.store'), 'id' => 'adminarea-cortex-attributes-attributes-create-form']) }}
                        @endif

                            <div class="row">

                                <div class="col-md-8">

                                    {{-- Name --}}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label('name', trans('cortex/attributes::common.name'), ['class' => 'control-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/attributes::common.name'), 'data-slugify' => '[name="slug"]', 'data-slugify-delimiter' => '_', 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                        @if ($errors->has('name'))
                                            <span class="help-block">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Slug --}}
                                    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                        {{ Form::label('slug', trans('cortex/attributes::common.slug'), ['class' => 'control-label']) }}
                                        {{ Form::text('slug', null, ['class' => 'form-control', 'placeholder' => trans('cortex/attributes::common.slug'), 'required' => 'required']) }}

                                        @if ($errors->has('slug'))
                                            <span class="help-block">{{ $errors->first('slug') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Type --}}
                                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                        {{ Form::label('type', trans('cortex/attributes::common.type'), ['class' => 'control-label']) }}
                                        {{ Form::select('type', $types, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/attributes::common.select_type'), 'required' => 'required', 'data-width' => '100%']) }}

                                        @if ($errors->has('type'))
                                            <span class="help-block">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Is Collection --}}
                                    <div class="form-group{{ $errors->has('is_collection') ? ' has-error' : '' }}">
                                        {{ Form::label('is_collection', trans('cortex/attributes::common.is_collection'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_collection', [0 => trans('cortex/attributes::common.no'), 1 => trans('cortex/attributes::common.yes')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'required' => 'required']) }}

                                        @if ($errors->has('is_collection'))
                                            <span class="help-block">{{ $errors->first('is_collection') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Required --}}
                                    <div class="form-group{{ $errors->has('is_required') ? ' has-error' : '' }}">
                                        {{ Form::label('is_required', trans('cortex/attributes::common.is_required'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_required', [0 => trans('cortex/attributes::common.no'), 1 => trans('cortex/attributes::common.yes')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'required' => 'required']) }}

                                        @if ($errors->has('is_required'))
                                            <span class="help-block">{{ $errors->first('is_required') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Sort Order --}}
                                    <div class="form-group{{ $errors->has('sort_order') ? ' has-error' : '' }}">
                                        {{ Form::label('sort_order', trans('cortex/attributes::common.sort_order'), ['class' => 'control-label']) }}
                                        {{ Form::number('sort_order', null, ['class' => 'form-control', 'placeholder' => trans('cortex/attributes::common.sort_order')]) }}

                                        @if ($errors->has('sort_order'))
                                            <span class="help-block">{{ $errors->first('sort_order') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Group --}}
                                    <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                        {{ Form::label('group', trans('cortex/attributes::common.group'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('group', '', ['class' => 'skip-validation']) }}
                                        {{ Form::select('group', $groups, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/attributes::common.select_group'), 'data-tags' => 'true', 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('group'))
                                            <span class="help-block">{{ $errors->first('group') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Entities --}}
                                    <div class="form-group{{ $errors->has('entities') ? ' has-error' : '' }}">
                                        {{ Form::label('entities[]', trans('cortex/attributes::common.entities'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('entities', '', ['class' => 'skip-validation']) }}
                                        {{ Form::select('entities[]', $entities, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/attributes::common.select_entities'), 'multiple' => 'multiple', 'data-width' => '100%']) }}

                                        @if ($errors->has('entities'))
                                            <span class="help-block">{{ $errors->first('entities') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-8">

                                    {{-- Description --}}
                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        {{ Form::label('description', trans('cortex/attributes::common.description'), ['class' => 'control-label']) }}
                                        {{ Form::textarea('description', null, ['class' => 'form-control tinymce', 'placeholder' => trans('cortex/attributes::common.description'), 'rows' => 3]) }}

                                        @if ($errors->has('description'))
                                            <span class="help-block">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Default --}}
                                    <div class="form-group{{ $errors->has('default') ? ' has-error' : '' }}">
                                        {{ Form::label('default', trans('cortex/attributes::common.default'), ['class' => 'control-label']) }}
                                        {{ Form::textarea('default', null, ['class' => 'form-control', 'placeholder' => trans('cortex/attributes::common.default'), 'rows' => 3]) }}

                                        @if ($errors->has('default'))
                                            <span class="help-block">{{ $errors->first('default') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="pull-right">
                                        {{ Form::button(trans('cortex/attributes::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                    </div>

                                    @include('cortex/foundation::adminarea.partials.timestamps', ['model' => $attribute])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
