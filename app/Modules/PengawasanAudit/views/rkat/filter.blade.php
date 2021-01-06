{{ Form::open(['url' => '/rkat-audit/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
<div class="card card-teal collapsed-card">
    <div class="card-header">
        <h3 class="card-title">{{ __('label.filter') }}</h3>
        {!! Html::cardCollapse() !!}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                {{ Form::fgSelect('Lembaga Jasa Keuangan', 'ljk', to_dropdown($company_name), request()->ljk, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>

    <div class="card-footer">
        {{ Form::fgFilterButton() }}
    </div>
</div>
{{ Form::close() }}