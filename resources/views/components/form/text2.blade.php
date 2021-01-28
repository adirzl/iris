<div class="form-group {{ $layout ? 'row' : '' }}">
    @if($layout)
        <div class="col-md-9">
            {{ Form::$type($name, $value, $attributes) }}
            @if(!is_null($help))
                <small class="form-text text-muted">{{ $help }}</small>
            @endif
        </div>
    @else
        <label for="">{{ $label }}</label>
        {{ Form::$type($name, $value, $attributes) }}
        @if(!is_null($help))
            <small class="form-text text-muted">{{ $help }}</small>
        @endif
    @endif
</div>
