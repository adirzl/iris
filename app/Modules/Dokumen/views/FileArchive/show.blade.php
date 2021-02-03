@php
$segment = request()->segment(2);
$title = 'show';
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Dokumen Upload')
@section('content')
        <div class="card card-success">
            <div class="card-body">
            <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>Unit Kerja</th>
                        <th>Type</th>
                        <th>File</th>
                        <th>Versi</th>
                        <th>Date Create</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->unitkerja->nama }}</td>
                            <td>{{ $d->file_type->name }}</td>
                            <td>
                            <a href="{{asset($d->path)}}">
                                No {{$d->version}} {{format_date($d->created_at,'%e %B %Y')}}
                            </a>
                            </td>
                            <td>{{ $d->version }}</td>
                            <td>{{ $d->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix text-right">
                <a href="{{url('dokumen-filearchive')}}" class="btn btn-warning btn-sm"><i class="fa fa-backward"></i>&nbsp; Kembali</a>
            </div>
        </div>

@endsection