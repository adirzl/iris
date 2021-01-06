<div class="form-group {{ $layout ? 'row' : '' }}">
    @if($layout)
        <label for="" class="col-md-2 col-form-label">{{ $label }}</label>
        <div class="col-md-10">
            @foreach ($options as $key => $val)
                <div class="{{ $type }}-inline">
                    <label for="">
                        {{ Form::$type($name, $key, ($key == $value), ['id' => to_lower(str_replace([' ', '-'], '', $val))]) }}
                        {{ $val }}
                    </label>
                </div>
            @endforeach
            @if(!is_null($help))
                <small class="form-text text-muted">{{ $help }}</small>
            @endif
        </div>
    @else
        <label for="">{{ $label }}</label>
        @foreach ($options as $key => $val)
            <div class="{{ $type }}">
                <label for="">
                    {{ Form::$type($name, $key, ($key == $value), ['id' => to_lower(str_replace([' ', '-'], '', $val))]) }}
                    {{ $val }}
                </label>
            </div>
        @endforeach
        @if(!is_null($help))
            <small class="form-text text-muted">{{ $help }}</small>
        @endif
    @endif
</div>
