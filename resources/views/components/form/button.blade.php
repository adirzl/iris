@if($action === 'create' || $action !== 'show')
<button class="btn btn-primary btn-sm save-close">
    <i class="fa fa-backward"></i> {{ __('button.save_close') }}
</button>&nbsp;
<button type="reset" class="btn btn-warning btn-sm reset">
    <i class="fa fa-redo"></i> {{ __('button.reset') }}
</button>&nbsp;
<a href="{{ route($uri . '.index', $parameter) }}" class="btn btn-danger btn-sm">
    <i class="fa fa-times"></i> {{ __('button.cancel') }}
</a>
@else
<a href="{{ route($uri . '.index', $parameter) }}" class="btn btn-danger btn-sm">
    <i class="fa fa-times"></i> {{ __('button.back') }}
</a>
@endif
