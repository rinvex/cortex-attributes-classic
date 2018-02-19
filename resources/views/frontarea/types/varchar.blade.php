@if ($attribute->is_collection)
    <div class="row">

        <div class="col-md-12">
            {{ Form::label($attribute->name, $attribute->title, ['class' => 'control-label']) }}

            @php
                $values = old($attribute->name) ?? ($entity->{$attribute->name}->count() ? $entity->{$attribute->name} : ['']);
            @endphp

            @foreach($values as $value)

                <div class="entry form-group{{ $errors->has($attribute->name.'.'.$loop->index) ? ' has-error' : '' }}">

                    <div class="input-group">
                        {{ Form::text($attribute->name.'[]', ! $entity->exists ? $attribute->default : $value, ['class' => 'form-control', 'placeholder' => $attribute->title, 'required' => $attribute->is_required ? 'required' : false]) }}
                        <span class="input-group-btn">
                            @if($loop->last)
                                <button class="btn btn-success btn-add" type="button">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            @else
                                <button class="btn btn-danger btn-remove" type="button">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            @endif
                        </span>
                    </div>

                    @if ($errors->has($attribute->name.'.'.$loop->index))
                        <span class="help-block">{{ $errors->first($attribute->name.'.'.$loop->index) }}</span>
                    @endif
                </div>

            @endforeach

        </div>

    </div>
@else
    <div class="row">

        <div class="col-md-12">

            <div class="form-group{{ $errors->has($attribute->name) ? ' has-error' : '' }}">
                {{ Form::label($attribute->name, $attribute->title, ['class' => 'control-label']) }}
                {{ Form::text($attribute->name, ! $entity->exists ? $attribute->default : $entity->{$attribute->name}, ['class' => 'form-control', 'placeholder' => $attribute->title, 'required' => $attribute->is_required ? 'required' : false]) }}

                @if ($errors->has($attribute->name))
                    <span class="help-block">{{ $errors->first($attribute->name) }}</span>
                @endif
            </div>

        </div>

    </div>
@endif
