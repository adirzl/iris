@extends('layouts.app_landing')
@section('content')

    <section id="slider" class="slider-element slider-parallax swiper_wrapper vh-75" data-margin="1" data-pagi="false"
        data-autoplay="5000" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-xl="4">
        <div class="slider-inner">

            <div class="swiper-container swiper-parent">
                <div class="swiper-wrapper">
                    @foreach ($data as $v)
                        @if ($v->status == 1)
                            <div class="swiper-slide dark">
                                <div class="container">
                                    <div class="slider-caption slider-caption-left">
                                        <h2 data-animate="fadeInUp">DMA</h2>
                                        <p class="d-none d-sm-block" data-animate="fadeInUp" data-delay="200">Documents
                                            Management Application
                                        </p>
                                    </div>
                                </div>
                                <div class="swiper-slide-bg" style="background-image: url('banner/{{ $v->image }}');"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
                <div class="slider-arrow-right"><i class="icon-angle-right"></i></div>
                <div class="slide-number">
                    <div class="slide-number-current"></div><span>/</span>
                    <div class="slide-number-total"></div>
                </div>
            </div>

        </div>
    </section>

    <!-- Content ============================================= -->
    <section id="content">
        <div class="content-wrap">

            <div class="promo promo-light promo-full bottommargin-lg header-stick border-top-0 p-5">
                <div class="container clearfix">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg">
                            <h3>Documents Management Application (<span> DMA</span> )</h3>
                            <span>Merupakan sebuah <em>wadah peng arsipan dokumen</em> yang dibentuk untuk mengintegrasikan
                                <em>seluruh dokumentasi</em> <br>dan <em>tata kelola dokumen</em> di lingkungan
                                <em>Bank bjb</em></span>
                        </div>
                        {{-- <div class="col-12 col-lg-auto mt-4 mt-lg-0">
                            <a href="{{ url(auth()->check() ? 'home' : 'login_iris') }}" target="blank"
                                class="button button-large button-circle m-0">Login</a>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="container clearfix">

                <div id="section-specs" class="heading-block text-center page-section">
                    <h2>Divisi Perencanaan</h2>
                    <span>Sekilas tentang Divisi Perencanaan</span>
                </div>

                <div id="side-navigation" class="row" data-plugin="tabs">

                    <div class="col-md-4">

                        <ul class="sidenav">
                            <li><a href="#snav-content1"><i class="icon-screen"></i>Profil<i
                                        class="icon-chevron-right"></i></a></li>
                            <li><a href="#snav-content2"><i class="icon-rocket"></i>Visi dan Misi<i
                                        class="icon-chevron-right"></i></a></li>
                            <li><a href="#snav-content3"><i class="icon-user"></i>Sekapur Sirih Pimpinan Divisi<i
                                        class="icon-chevron-right"></i></a></li>
                        </ul>

                    </div>

                    <div class="col-md-8">

                        <div id="snav-content1">
                            <h3>Profil</h3>
                            <img class="alignright img-responsive" src="http://127.0.0.1:8080/img/logo.png" width="30%"
                                height="30%" alt="Image">

                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, ex, inventore, tenetur, repellat
                            ipsam soluta libero amet nam aspernatur perspiciatis quos praesentium et debitis ea odit enim
                            illo aliquid eligendi numquam neque. Ipsum, voluptatibus, perspiciatis a quam aliquid cumque
                            cupiditate id ipsa tempora eveniet. Cupiditate, necessitatibus, consequatur odio. Lorem ipsum
                            dolor sit amet, consectetur adipisicing elit. Dicta, vitae, laboriosam libero nihil labore hic
                            modi? Odit, veritatis nulla molestiae!
                        </div>

                        <div id="snav-content2">
                            <h3>Visi dan Misi</h3>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam, voluptatem reprehenderit natus
                            facilis id deserunt iusto incidunt cumque odit molestias iste dolor eum esse soluta facere
                            quidem minima in voluptate explicabo ducimus alias ratione aut molestiae omnis fuga labore quod
                            optio modi voluptatum nemo suscipit porro maxime ex. Maiores, ratione eligendi labore quaerat
                            veniam laborum nam rem delectus illum aspernatur quas sequi animi quae nulla alias hic inventore
                            ex perspiciatis nisi consequatur enim a aut dolorum modi quod perferendis dicta impedit magni
                            placeat repellat. Soluta, dicta, dolores, reiciendis, eum accusamus esse et debitis rem fugit
                            fugiat dignissimos pariatur sint quod laborum autem. Nulla, ducimus, culpa, vel esse unde
                            sapiente expedita corrupti consectetur veritatis quas autem laborum mollmquam amet eius.
                            Numquam, ad, quaerat, ab, deleniti rem quae doloremque tenetur ea illum hic amet dolor suscipit
                            porro ducimus excepturi perspiciatis modi praesentium voluptas quos expedita provident adipisci
                            dolorem! Aliquam, ipsum voluptatem et voluptates impedit ab libero similique a. Nisi, ea magni
                            et ab voluptatum nemo numquam odio quis libero aspernatur architecto tempore qui quisquam saepe
                            corrupti necessitatibus natus quos aliquid non voluptatibus quod obcaecati fugiat quibusdam
                            quidem inventore quia eveniet iusto culpa incidunt vero vel in accusamus eum. Molestiae nihil
                            voluptate molestias illum eligendi esse nesciunt.
                        </div>

                        <div id="snav-content3">
                            <img class="alignleft img-responsive" src="http://127.0.0.1:8080/img/team2.png" alt="Image">
                            <h3>Sekapur Sirih Pimpinan Divisi</h3>
                            Dolor aperiam modi aliquam dolores consequatur error commodi ad
                            eius incidunt! Libero, odio incidunt ullam sunt fugiat? Laboriosam, perferendis, debitis, harum
                            soluta iste eos sunt odit architecto porro eveniet sint optio nihil animi. Laudantium, quam,
                            culpa, velit molestias exercitationem reprehenderit enim distinctio aliquam aut ex numquam sequi
                            assumenda veritatis fuga voluptatum. Magni, voluptates adipisci unde sapiente eligendi ea maxime
                            tempora pariatur ipsa.. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae,
                            aspernatur, saepe, quidem animi hic rem libero earum fuga voluptas culpa iure qui accusantium ab
                            quae dolorum laborum quia repellat fugit aut minima molestias placeat mollitia doloribus
                            quibusdam consectetur officia nesciunt ad. Ab, quod ipsum commodi assumenda doloribus possimus
                            sed laudantium.Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="page-title">
        <div class="container clearfix">
            {{-- <h1>{{ strtoupper($unitkerja->name) }}</h1> --}}
            <h1>Arsip Dokumen</h1>
            <span>Deskripsi singkat judul</span>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row">
                    <div class="postcontent col-lg-9">
                        <ul>
                            {{-- @foreach ($data as $item)
                                <li>{{ $item->name }}</li>
                            @endforeach --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Actions</th>
                                            <th>Nomor</th>
                                            <th>Nama Dokumen</th>
                                            <th>Kategori</th>
                                            <th>Type</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Actions</button>
                                                    <button type="button"
                                                        class="btn btn-info dropdown-toggle dropdown-toggle-split"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">View</a>
                                                        <a class="dropdown-item" href="#">Download</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>1</td>
                                            <td>Kajian stabilitas keuangan</td>
                                            <td>docx</td>
                                            <td>no 32 November 2020</td>
                                            <td>20-01-2021</td>
                                            <td><span class="badge bg-success" style="color: white">Public</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Actions</button>
                                                    <button type="button"
                                                        class="btn btn-info dropdown-toggle dropdown-toggle-split"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Request</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2</td>
                                            <td>RBB Bank bjb 2021</td>
                                            <td>pdf</td>
                                            <td>no 12 Desember 2020</td>
                                            <td>20-01-2021</td>
                                            <td><span class="badge bg-warning">Private</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </ul>
                    </div>

                    <div class="sidebar col-lg-3">
                        <div class="sidebar-widgets-wrap">
                            <div class="widget clearfix">
                                {{ Form::text('keyword', null, ['class' => 'form-control', 'id' => 'keyword', 'placeholder' => 'Pencarian']) }}
                                <br>
                                <button class="btn btn-primary">Cari</button>
                                <div style="margin-top: 10%">
                                    <label>File Type</label>
                                    <li>{{ Form::checkbox('fileType[]', true, null) }} [name]</li>
                                    {{-- @foreach ($fileType as $item)
                                        <ul>
                                            <li>{{ Form::checkbox('fileType[]', true, null) }} {{ $item->name }}</li>
                                        </ul>
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- #content end -->
@endsection
