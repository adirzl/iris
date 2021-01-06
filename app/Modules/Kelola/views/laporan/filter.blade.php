{{ Form::open(['url' => '/kelola-laporan/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
    <div class="card card-teal collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ __('label.filter') }}</h3>
            {!! Html::cardCollapse() !!}
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-4">
                    {{ Form::fgSelect('Anak Perusahaan', 'company_name', to_dropdown($company_name), request()->company_name, ['class' => 'form-control']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::fgText('Judul Laporan', 'title', request()->title, ['class' => 'form-control']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::fgSelect('Status', 'status', to_dropdown($status_laporan), request()->status, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            {{ Form::fgFilterButton() }}
        </div>
    </div>
{{ Form::close() }}
