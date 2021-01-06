{{ Form::open(['url' => '/log-transaksi/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
    <div class="card card-teal collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ __('label.filter') }}</h3>
            {!! Html::cardCollapse() !!}
        </div>

        <div class="card-body">
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="" class="col-md-2 col-form-label text-left">Tanggal</label>
                    <div class="col-md-4">
                        {{ Form::text('tgl_awal', request()->tgl_awal, ['class' => 'form-control datepick']) }}
                    </div>
                    <div class="col-md-2 text-center">s.d</div>
                    <div class="col-md-4">
                        {{ Form::text('tgl_akhir', request()->tgl_akhir, ['class' => 'form-control datepick']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            {{ Form::fgFilterButton() }}
        </div>
    </div>
{{ Form::close() }}
