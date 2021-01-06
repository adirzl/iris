@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="row">
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-user-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total File Laporan Sudah Diupload</span>
                        <span class="info-box-number">
                            <h1>{{ number_format($data['laporan']) }}</h1>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-money-bill"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Jumlah Artikel/Berita</span>
                        <span class="info-box-number">
                            <h1>{{ number_format($data['artikel']) }}</h1>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-list-ol"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Kuisioner Yang Sudah Diisi</span>
                        <span class="info-box-number">
                            <h1>{{ number_format($data['penilaian']) }}</h1>
                        </span>
                    </div>
                </div>
            </div>
        </div>
@endsection
