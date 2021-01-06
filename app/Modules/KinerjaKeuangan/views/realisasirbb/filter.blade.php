{{ Form::open(['url' => '/realisasi-rbb/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
<div class="card card-teal collapsed-card">
    <div class="card-header">
        <h3 class="card-title">{{ __('label.filter') }}</h3>
        {!! Html::cardCollapse() !!}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                {{ Form::fgSelect('Lembaga Jasa Keuangan', 'id_comprof', to_dropdown($company_name), request()->id_comprof, ['class' => 'form-control']) }}
            </div>
            <div class="col-md-3">
                {{-- {{ Form::fgText('Tahun', 'tahun', null, ['class' => 'form-control yearpick', 'placeholder' => 'Tahun'], null, 'text', true) }} --}}
                {{ Form::fgText('Tahun', 'tahun', request()->tahun, ['class' => 'form-control yearpick', 'placeholder' => 'Tahun']) }}
            </div>
        </div>
    </div>

    <div class="card-footer">
        {{ Form::fgFilterButton() }}
    </div>
</div>
{{ Form::close() }}