@if ($attribute->is_collection)
    <div class="row">

        <div class="col-md-12">
            {{ Form::label($attribute->slug, $attribute->name, ['class' => 'control-label']) }}

            @php
                $values = old($attribute->slug) ?? ($entity->{$attribute->slug}->count() ? $entity->{$attribute->slug} : ['']);
            @endphp

            @foreach($values as $value)

                <div class="entry form-group{{ $errors->has($attribute->slug.'.'.$loop->index) ? ' has-error' : '' }}">

                    <div class="input-group">
                        {{ Form::text($attribute->slug.'[]', ! $entity->exists ? $attribute->default : $value, ['class' => 'form-control', 'placeholder' => $attribute->name, 'required' => $attribute->is_required ? 'required' : false]) }}
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

                    @if ($errors->has($attribute->slug.'.'.$loop->index))
                        <span class="help-block">{{ $errors->first($attribute->slug.'.'.$loop->index) }}</span>
                    @endif

                </div>

            @endforeach

        </div>

    </div>
@else
    <div class="row">

        <div class="col-md-12">

            <div class="form-group{{ $errors->has($attribute->slug) ? ' has-error' : '' }}">
                {{ Form::label($attribute->slug, $attribute->name, ['class' => 'control-label']) }}
                {{ Form::text($attribute->slug, ! $entity->exists ? $attribute->default : $entity->{$attribute->slug}, ['class' => 'form-control', 'placeholder' => $attribute->name, 'required' => $attribute->is_required ? 'required' : false]) }}

                @if ($errors->has($attribute->slug))
                    <span class="help-block">{{ $errors->first($attribute->slug) }}</span>
                @endif
            </div>

        </div>

    </div>
@endif
