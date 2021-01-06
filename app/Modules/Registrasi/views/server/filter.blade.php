{{ Form::open(['url' => '/registrasi-server/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
    <div class="card card-teal collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ __('label.filter') }}</h3>
            {!! Html::cardCollapse() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {{ Form::fgText('IP Aplikasi', 'ip_address', request()->ip_address, ['class' => 'form-control ipaddr']) }}
                </div>

                <div class="col-md-6">
                    {{ Form::fgText('Nama Aplikasi', 'nama', request()->nama, ['class' => 'form-control']) }}
                </div>

                <div class="col-md-6">
                    {{ Form::fgSelect('Environment', 'environment', to_dropdown($environment), request()->environment, ['class' => 'form-control']) }}
                </div>

                <div class="col-md-6">
                    {{ Form::fgSelect('Koneksi', 'koneksi', to_dropdown($environment), request()->koneksi, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            {{ Form::fgFilterButton() }}
        </div>
    </div>
{{ Form::close() }}
