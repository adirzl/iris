@extends('layouts.app')
@section('title', 'Log Aplikasi')
@section('content')
    @if(count($files))
        <div class="card card-success">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <ul class="list-group">
                            @foreach($files as $file)
                                <li class="list-group-item">
                                    <a href="{{ url('/log-aplikasi?l=' . encrypt($file)) }}">{{ $file }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-9">
                        <div class="btn-group pull-left mb-2">
                            <a href="{{ url('/log-aplikasi?dl=' . encrypt($current_file)) }}" class="btn btn-default">{{ __('button.download') }}</a>
                            @can('clean log-aplikasi')
                                <a href="{{ url('/log-aplikasi?clean=' . encrypt($current_file)) }}" class="btn btn-default">{{ __('button.clean_log') }}</a>
                            @endcan
                            @can('delete log-aplikasi')
                                <a href="{{ url('/log-aplikasi?del=' . encrypt($current_file)) }}" class="btn btn-default">{{ __('button.delete') }}</a>
                            @endcan
                        </div>
                        @can('delete_all log-aplikasi')
                            <a href="{{ url('/log-aplikasi?delall=true') }}" class="btn btn-default pull-right">{{ __('button.delete_all') }} log file(s)</a>
                        @endcan
                        @if($logs === null)
                            <div class="alert alert-info">File log > 50M, harap unduh.</div>
                        @else
                            <div class="col-lg-12 text-center mb-2">
                                <h3>{{ $current_file }}</h3>
                            </div>
                            <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                                <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Context</th>
                                    <th>Date</th>
                                    <th>Content</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $key => $log)
                                    <tr>
                                        <td class="text-{{ $log['level_class'] }}">
                                            <span class="fa fa-{{ $log['level_img'] }}" aria-hidden="true"></span>
                                            {{ $log['level'] }}
                                        </td>
                                        <td>{{ $log['context'] }}</td>
                                        <td>{{ $log['date'] !== 1 ? $log['date'] : '' }}</td>
                                        <td>
                                            @if($log['text'])
                                            <a href="#modal-{{ $key }}" data-toggle="modal" data-target="#modal-{{ $key }}">
                                                [{{ \Illuminate\Support\Str::limit($log['text'], 50) }}]
                                            </a>
                                            @include('log::log-aplikasi.modal')
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection