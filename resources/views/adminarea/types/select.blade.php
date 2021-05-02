<div>Soon!</div>

{{-- @TODO
<div class="row">

    <div class="col-md-12">

        <div class="form-group{{ $errors->has($attribute->slug) ? ' has-error' : '' }}">

            {{ Form::label($attribute->slug, $attribute->name, ['class' => 'control-label']) }}
            {{ Form::select($attribute->slug, $default, ! $entity->exists ? $selected : $entity->{$attribute->slug}, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'multiple' => $attribute->is_collection]) }}

            @if ($errors->has($attribute->slug))
                <span class="help-block">{{ $errors->first($attribute->slug) }}</span>
            @endif

        </div>

    </div>

</div>
--}}
