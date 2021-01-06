<div class="modal fade" id="modal-{{ $d->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Properti</h4>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @php($properties = json_decode($d->properties, true))
                @foreach ($properties as $key => $prop)
                    @if(isset($prop['id']))
                        @php(\Illuminate\Support\Arr::forget($prop, 'id'))
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>{{ strtoupper($key) }}</h4>
                            <blockquote>{{ print_r($prop, true) }}</blockquote>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('button.close') }}</button>
            </div>
        </div>
    </div>
</div>