<div class="modal fade" id="modal-{{ $key }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Isi Log</h4>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <blockquote class="small">{{ $log['text'] }}</blockquote>
                    </div>

                    @if ($log['stack'])
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Stacktrace
                                    <div class="panel-action">
                                        <a href="javascript:void(0);" data-perform="panel-collapse"><i class="ti-plus"></i></a>
                                    </div>
                                </div>

                                <div class="panel-wrapper collapse">
                                    @php($stack = str_replace('', '', trim($log['stack'])))
                                    @php($stacks = explode('#', $stack))
                                    @php(array_shift($stacks))
                                    <ol class="m-t-40">
                                        @foreach ($stacks as $stack)
                                            <li>{{ $stack }}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('button.close') }}</button>
            </div>
        </div>
    </div>
</div>