{{ Form::open(['url' => '/pegawai-hcs/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
    <div class="card card-teal collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ __('label.filter') }}</h3>
            {!! Html::cardCollapse() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    {{ Form::fgText('Nama', 'nama', request()->nama, ['class' => 'form-control ucase']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::fgSelect('Unit Kerja', 'unit_kerja', $unitKerja, request()->unit_kerja, ['class' => 'form-control select2']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::fgSelect('Status', 'status', $statusKaryawan, request()->status, ['class' => 'form-control select2']) }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            {{ Form::fgFilterButton() }}
        </div>
    </div>
{{ Form::close() }}
