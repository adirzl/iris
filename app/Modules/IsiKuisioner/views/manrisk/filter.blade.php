{{ Form::open(['url' => '/isikuisioner-manrisk/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
<div class="card card-teal collapsed-card">
    <div class="card-header">
        <h3 class="card-title">{{ __('label.filter') }}</h3>
        {!! Html::cardCollapse() !!}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                {{ Form::fgSelect('Anak Perusahaan', 'nama_perusahaan', to_dropdown($company_name), request()->nama_perusahaan, ['class' => 'form-control']) }}
            </div>
            <div class="col-md-4">
                {{ Form::fgSelect('Periode', 'periode', to_dropdown($periode), request()->periode, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>

    <div class="card-footer">
        {{ Form::fgFilterButton() }}
    </div>
</div>
{{ Form::close() }}