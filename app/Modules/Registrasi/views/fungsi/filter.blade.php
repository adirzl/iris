{{ Form::open(['url' => '/registrasi-aplikasi-fungsi/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
    <div class="card card-teal collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ __('label.filter') }}</h3>
            {!! Html::cardCollapse() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    {{ Form::fgSelect('Aplikasi', 'aplikasi', $aplikasi, request()->aplikasi, ['class' => 'form-control select2']) }}
                </div>
                
                <div class="col-md-4">
                    {{ Form::fgText('Nama Fungsi', 'nama', request()->nama, ['class' => 'form-control']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::fgSelect('Sinkronisasi', 'sinkronisasi', to_dropdown($bool_decision), request()->sinkronisasi, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            {{ Form::fgFilterButton() }}
        </div>
    </div>
{{ Form::close() }}
