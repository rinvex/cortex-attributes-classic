<div class="row">

    <div class="col-md-12">

        <div class="form-group{{ $errors->has($attribute->slug) ? ' has-error' : '' }}">
            {{ Form::label($attribute->slug, $attribute->name, ['class' => 'control-label']) }}

            @foreach($default as $name => $details)
                <br />
                {{ Form::checkbox($attribute->slug.'[]', $name, $details['status'], ['id' => $name]) }}
                {{ Form::label($name, $details['label'], ['class' => 'control-label']) }}
            @endforeach

            @if ($errors->has($attribute->slug))
                <span class="help-block">{{ $errors->first($attribute->slug) }}</span>
            @endif

        </div>

    </div>

</div>
