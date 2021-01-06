{{ Form::open(['url' => '/sinkronisasi-pegawai/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
    <div class="card card-teal collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ __('label.filter') }}</h3>
            {!! Html::cardCollapse() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {{ Form::fgText('User ID', 'userid', request()->userid, ['class' => 'form-control ucase']) }}
                </div>

                <div class="col-md-6">
                    {{ Form::fgText('Nama', 'nama', request()->nama, ['class' => 'form-control ucase']) }}
                </div>

                <div class="col-md-6">
                    {{ Form::fgSelect('Sinkronisasi', 'sinkronisasi', to_dropdown($bool_decision), request()->sinkronisasi, ['class' => 'form-control']) }}
                </div>

                <div class="col-md-6">
                    {{ Form::fgText('Tgl. Sinkronisasi', 'tanggal', request()->tanggal ?? now()->format('Y-m-d'), ['class' => 'form-control datepick']) }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            {{ Form::fgFilterButton() }}
        </div>
    </div>
{{ Form::close() }}
