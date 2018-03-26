<div class="row">

    <div class="col-md-12">

        <div class="form-group{{ $errors->has($attribute->name) ? ' has-error' : '' }}">

            {{ Form::label($attribute->name, $attribute->title, ['class' => 'control-label']) }}
            {{ Form::select($attribute->name, $default, ! $entity->exists ? $selected : $entity->{$attribute->name}, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'multiple' => $attribute->is_collection]) }}

            @if ($errors->has($attribute->name))
                <span class="help-block">{{ $errors->first($attribute->name) }}</span>
            @endif

        </div>

    </div>

</div>
