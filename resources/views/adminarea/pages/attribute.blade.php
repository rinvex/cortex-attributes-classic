{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.adminarea') }} » {{ trans('cortex/attributes::common.attributes') }} » {{ $attribute->exists ? $attribute->name : trans('cortex/attributes::common.create_attribute') }}
@stop

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Attributes\Http\Requests\Adminarea\AttributeFormRequest::class)->selector("#adminarea-attributes-create-form, #adminarea-attributes-{$attribute->getKey()}-update-form") !!}
@endpush

{{-- Main Content --}}
@section('content')

    @if($attribute->exists)
        @include('cortex/foundation::common.partials.confirm-deletion', ['type' => 'attribute'])
    @endif

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details-tab" data-toggle="tab">{{ trans('cortex/attributes::common.details') }}</a></li>
                    @if($attribute->exists) <li><a href="#logs-tab" data-toggle="tab">{{ trans('cortex/attributes::common.logs') }}</a></li> @endif
                    @if($attribute->exists && $currentUser->can('delete-attributes', $attribute)) <li class="pull-right"><a href="#" data-toggle="modal" data-target="#delete-confirmation" data-item-href="{{ route('adminarea.attributes.delete', ['attribute' => $attribute]) }}" data-item-name="{{ $attribute->slug }}"><i class="fa fa-trash text-danger"></i></a></li> @endif
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($attribute->exists)
                            {{ Form::model($attribute, ['url' => route('adminarea.attributes.update', ['attribute' => $attribute]), 'method' => 'put', 'id' => "adminarea-attributes-{$attribute->getKey()}-update-form"]) }}
                        @else
                            {{ Form::model($attribute, ['url' => route('adminarea.attributes.store'), 'id' => 'adminarea-attributes-create-form']) }}
                        @endif

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Name --}}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label('name', trans('cortex/attributes::common.name'), ['class' => 'control-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/attributes::common.name'), 'data-slugify' => '#slug', 'required' => 'required', 'autofocus' => 'autofocus']) }}

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

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Group --}}
                                    <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                        {{ Form::label('group', trans('cortex/attributes::common.group'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('group', '') }}
                                        {{ Form::select('group', $groups, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/attributes::common.select_group'), 'data-tags' => 'true', 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('group'))
                                            <span class="help-block">{{ $errors->first('group') }}</span>
                                        @endif
                                    </div>

                                </div>

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

                                    {{-- Default --}}
                                    <div class="form-group{{ $errors->has('default') ? ' has-error' : '' }}">
                                        {{ Form::label('default', trans('cortex/attributes::common.default'), ['class' => 'control-label']) }}
                                        {{ Form::text('default', null, ['class' => 'form-control', 'placeholder' => trans('cortex/attributes::common.default')]) }}

                                        @if ($errors->has('default'))
                                            <span class="help-block">{{ $errors->first('default') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Collection --}}
                                    <div class="form-group{{ $errors->has('collection') ? ' has-error' : '' }}">
                                        {{ Form::label('collection', trans('cortex/attributes::common.collection'), ['class' => 'control-label']) }}
                                        {{ Form::select('collection', [0 => trans('cortex/attributes::common.no'), 1 => trans('cortex/attributes::common.yes')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%']) }}

                                        @if ($errors->has('collection'))
                                            <span class="help-block">{{ $errors->first('collection') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-8">

                                    {{-- Entities --}}
                                    <div class="form-group{{ $errors->has('entities') ? ' has-error' : '' }}">
                                        {{ Form::label('entities[]', trans('cortex/attributes::common.entities'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('entities', '') }}
                                        {{ Form::select('entities[]', $entities, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/attributes::common.select_entities'), 'multiple' => 'multiple', 'data-width' => '100%']) }}

                                        @if ($errors->has('entities'))
                                            <span class="help-block">{{ $errors->first('entities') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    {{-- Description --}}
                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        {{ Form::label('description', trans('cortex/attributes::common.description'), ['class' => 'control-label']) }}
                                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('cortex/attributes::common.description'), 'rows' => 3]) }}

                                        @if ($errors->has('description'))
                                            <span class="help-block">{{ $errors->first('description') }}</span>
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

                    @if($attribute->exists)

                        <div class="tab-pane" id="logs-tab">
                            {!! $logs->table(['class' => 'table table-striped table-hover responsive dataTableBuilder', 'id' => "adminarea-attributes-{$attribute->getKey()}-logs-table"]) !!}
                        </div>

                    @endif

                </div>

            </div>

        </section>

    </div>

@endsection

@if($attribute->exists)

    @push('styles')
        <link href="{{ mix('css/datatables.css', 'assets') }}" rel="stylesheet">
    @endpush

    @push('vendor-scripts')
        <script src="{{ mix('js/datatables.js', 'assets') }}" type="text/javascript"></script>
    @endpush

    @push('inline-scripts')
        {!! $logs->scripts() !!}
    @endpush

@endif
