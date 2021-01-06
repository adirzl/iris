{{ Form::open(['url' => '/grade-hcs/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
    <div class="card card-teal collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ __('label.filter') }}</h3>
            {!! Html::cardCollapse() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {{ Form::fgText('Nama', 'nama', request()->nama, ['class' => 'form-control']) }}
                </div>

                <div class="col-md-6">
                    {{ Form::fgSelect('Status', 'status', to_dropdown($status), request()->status, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            {{ Form::fgFilterButton() }}
        </div>
    </div>
{{ Form::close() }}
