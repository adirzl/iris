<div class="form-group {{ $layout ? 'row' : '' }}">
    @if($layout)
        <label for="" class="col-md-3 col-form-label">{{ $label }}</label>
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
