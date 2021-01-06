@if(session('success'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! session('success') !!}
            </div>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info alert-dismissable">
                <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! session('info') !!}
            </div>
        </div>
    </div>
@endif

@if(session('warning'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissable">
                <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! session('warning') !!}
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! session('error') !!}
            </div>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif