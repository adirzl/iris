<div class="form-group {{ $layout ? 'row' : '' }}">
    @if($layout)
        <div class="col-md-10">
            {{ Form::select($name, $options, $value, $attributes) }}
            @if(!is_null($help))
                <small class="form-text text-muted">{{ $help }}</small>
            @endif
        </div>
    @else
        <label for="">{{ $label }}</label>
        {{ Form::select($name, $options, $value, $attributes) }}
        @if(!is_null($help))
            <small class="form-text text-muted">{{ $help }}</small>
        @endif
    @endif
</div>
