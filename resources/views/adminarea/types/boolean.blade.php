<div class="row">

    <div class="col-md-12">

        <div class="form-group{{ $errors->has($attribute->slug) ? ' has-error' : '' }}">

            {{ Form::label($attribute->slug, $attribute->name, ['class' => 'control-label']) }}

            <div class="radio">{{ Form::label($attribute->slug.'-1', Form::radio($attribute->slug, 1, (bool) (! $entity->exists ? $attribute->default : $entity->{$attribute->slug}), ['required' => $attribute->is_required ? 'required' : false, 'id' => $attribute->slug.'-1']).trans('cortex/attributes::common.yes'), ['class' => 'control-label'], false) }}</div>
            <div class="radio">{{ Form::label($attribute->slug.'-0', Form::radio($attribute->slug, 0, (bool) (! $entity->exists ? $attribute->default : $entity->{$attribute->slug}), ['required' => $attribute->is_required ? 'required' : false, 'id' => $attribute->slug.'-0']).trans('cortex/attributes::common.no'), ['class' => 'control-label'], false) }}</div>

            @if ($errors->has($attribute->slug))
                <span class="help-block">{{ $errors->first($attribute->slug) }}</span>
            @endif

        </div>

    </div>

</div>
