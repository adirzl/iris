@extends('layouts.app_landing')
@section('content')
<!-- Content ============================================= -->
<div class="section">
    <div class="container">

        <div class="heading-block center">
            <h2>Tugas dan Wewenang</h2>
        </div>

        <div class="row col-mb-50">
            <div class="col-12">
                <img data-animate="fadeIn" class="aligncenter" src="{{ asset('app-assets/images/logo-bjb.png') }}" alt="Bank bjb" style="width: 50%;">
            </div>

            <div class="col-md-12">
                <div class="title-block">
                    <h3>Tugas</h3>
                    <span>Entitas Utama</span>
                </div>
            </div>
            
            @foreach($data as $v)
                @if($v->status == 1)
                    <div class="col-md-4">
                        <div class="feature-box fbox-plain">
                            <div class="fbox-icon">
                                <a href="#">
                                    <i class="i-alt">
                                        @if($i <= $jml)
                                            {{ $i = $i+1 }}.
                                        @endif
                                    </i>
                                </a>
                            </div>
                            <div class="fbox-content">
                                <h3>{{$v->title}}</h3>
                                <p>{{$v->description}}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="col-md-12">
                <div class="title-block">
                    <h3>Wewenang</h3>
                    <span>Entitas Utama</span>
                </div>
            </div>

            @foreach($data2 as $w)
                @if($w->status == 1)
                    <div class="col-md-4">
                        <div class="feature-box fbox-plain">
                            <div class="fbox-icon">
                                <a href="#">
                                    <i class="i-alt">
                                        @if($j <= $jml2)
                                            {{ $j = $j+1 }}.
                                        @endif
                                    </i>
                                </a>
                            </div>
                            <div class="fbox-content">
                                <h3>{{$w->title}}</h3>
                                <p>{{$w->description}}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>

    </div>
</div>
<!-- #content end -->
@endsection