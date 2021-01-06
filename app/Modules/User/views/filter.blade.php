{{ Form::open(['url' => '/user/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
    <div class="card card-teal collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ __('label.filter') }}</h3>
            {!! Html::cardCollapse() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {{ Form::fgSelect('Hak Akses', 'role_id', $roles, request()->role_id, ['class' => 'form-control']) }}
                </div>

                <div class="col-md-6">
                    {{ Form::fgSelect('Status', 'is_active', to_dropdown($status_user), request()->is_active, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            {{ Form::fgFilterButton() }}
        </div>
    </div>
{{ Form::close() }}
