{{ Form::open(['url' => '/kuisioner-pertanyaan/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
    <div class="card card-teal collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ __('label.filter') }}</h3>
            {!! Html::cardCollapse() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    {{ Form::fgText('Description', 'description', request()->title, ['class' => 'form-control']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::fgSelect('Status', 'status', to_dropdown($status_pertanyaan), request()->status, ['class' => 'form-control']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::fgSelect('Kategori User', 'status_user', to_dropdown($status_user), request()->status_user, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            {{ Form::fgFilterButton() }}
        </div>
    </div>
{{ Form::close() }}
