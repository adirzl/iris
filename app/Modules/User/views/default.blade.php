@extends('layouts.app')
@section('title', 'User')
@section('content')
    @include('user::filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Nama</th>
                        <th>Tgl. Verifikasi</th>
                        <th>Hak Akses</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                @php($blocked = $d->status == 9)
                                {!!
                                    Html::linkActions([
                                        [
                                            'url' => 'user.show', 'permission' => 'show user', 'attributes' => [
                                                'rel' => 'content',
                                                'title' => __('label.show_message', ['label' => $d->profile->nama])
                                            ], 'label' => __('label.show_message', ['label' => $d->profile->nama])
                                        ],
                                        [
                                            'url' => 'user.' . ($blocked ? 'unblock' : 'block'), 'permission' => ($blocked ? 'unblock' : 'block') . ' user', 'attributes' => [
                                                'rel' => 'post-action',
                                                'title' => ($blocked ? 'Buka blokir' : 'Blokir') . ' `' . $d->profile->nama . '`'
                                            ], 'label' => ($blocked ? 'Buka blokir' : 'Blokir') . ' `' . $d->profile->nama . '`'
                                        ],
                                        [
                                            'url' => 'user.destroy', 'permission' => 'destroy user', 'attributes' => [
                                                'rel' => 'delete',
                                                'title' => __('label.delete_message', ['label' => $d->profile->nama])
                                            ], 'label' => __('label.delete_message', ['label' => $d->profile->nama])
                                        ],
                                        [
                                            'url' => 'user.release', 'permission' => 'release user', 'attributes' => [
                                                'rel' => 'post-action', 'title' => 'Release ' . $d->profile->nama
                                            ], 'label' => 'Release ' . $d->profile->nama
                                        ],
                                    ], $d->id)
                                !!}
                            </td>
                            <td>{{ $d->profile->nama }}</td>
                            <td>{{ (is_null($d->email_verified_at) ? 'Belum verifikasi' : date_formatted($d->email_verified_at, '%d %B %Y %H:%M:%S')) }}</td>
                            <td>{{ $d->role }}</td>
                            <td>{{ $status_user[$d->status] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('user'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('user') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'User', 'uri' => route('user.create')]) !!}
        </div>
    @endif
@endsection