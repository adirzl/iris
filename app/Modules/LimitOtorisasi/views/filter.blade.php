{{ Form::open(['url' => '/limit-otorisasi/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
    <div class="card card-teal collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ __('label.filter') }}</h3>
            {!! Html::cardCollapse() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {{ Form::fgText('Kode Grup Limit', 'kode', request()->kode, ['class' => 'form-control ucase']) }}
                </div>
                
                <div class="col-md-6">
                    {{ Form::fgSelect('Jabatan', 'jabatan', $jabatan, request()->jabatan, ['class' => 'form-control select2']) }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            {{ Form::fgFilterButton() }}
        </div>
    </div>
{{ Form::close() }}
