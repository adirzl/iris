{{ Form::open(['url' => '/kelola-tugaswewenang/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
<div class="card card-teal collapsed-card">
    <div class="card-header">
        <h3 class="card-title">{{ __('label.filter') }}</h3>
        {!! Html::cardCollapse() !!}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                {{ Form::fgText('Title', 'title', request()->title, ['class' => 'form-control']) }}
            </div>

            <div class="col-md-4">
                {{ Form::fgSelect('Status Data', 'status_data', to_dropdown($status_data), request()->status_data, ['class' => 'form-control']) }}
            </div>

            <div class="col-md-4">
                {{ Form::fgSelect('Status', 'status', to_dropdown($status), request()->status, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>

    <div class="card-footer">
        {{ Form::fgFilterButton() }}
    </div>
</div>
{{ Form::close() }}