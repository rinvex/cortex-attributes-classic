<div class="row">

    <div class="col-md-12">

        <div class="form-group{{ $errors->has($attribute->name) ? ' has-error' : '' }}">

            {{ Form::label($attribute->name, $attribute->title, ['class' => 'control-label']) }}

            <div class="radio">{{ Form::label($attribute->name.'-1', Form::radio($attribute->name, 1, (bool) (! $entity->exists ? $attribute->default : $entity->{$attribute->name}), ['required' => $attribute->is_required ? 'required' : false, 'id' => $attribute->name.'-1']).trans('cortex/attributes::common.yes'), ['class' => 'control-label'], false) }}</div>
            <div class="radio">{{ Form::label($attribute->name.'-0', Form::radio($attribute->name, 0, (bool) (! $entity->exists ? $attribute->default : $entity->{$attribute->name}), ['required' => $attribute->is_required ? 'required' : false, 'id' => $attribute->name.'-0']).trans('cortex/attributes::common.no'), ['class' => 'control-label'], false) }}</div>

            @if ($errors->has($attribute->name))
                <span class="help-block">{{ $errors->first($attribute->name) }}</span>
            @endif

        </div>

    </div>

</div>
