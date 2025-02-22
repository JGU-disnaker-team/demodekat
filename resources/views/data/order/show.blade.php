@extends('layouts.app')

@section('content')
    <?php $user = Auth::user(); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header text-capitalize">Layanan</div>
                    <div class="card-body p-0">
                        <ul class="list-group">
                            <li class="list-group-item">{{ @$data->layanan->title }}</li>
                            @if ($user->getRoleNames()[0] == 'superadmin' || $user->getRoleNames()[0] == 'member')
                                <li class="list-group-item">{{ @$data->layanan->harga_member }}</li>
                            @endif
                            @if ($user->getRoleNames()[0] == 'superadmin' || $user->getRoleNames()[0] == 'worker')
                                <li class="list-group-item">{{ @$data->layanan->harga_worker }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
                @if ($user->getRoleNames()[0] == 'superadmin' || $user->getRoleNames()[0] == 'worker')
                    <div class="card mb-3">
                        <div class="card-header text-capitalize">Customer</div>
                        <div class="card-body p-0">
                            <ul class="list-group">
                                <li class="list-group-item">{{ @$data->customer->name }}</li>
                                <li class="list-group-item">{{ @$data->customer->alamat }}</li>
                                @if ($user->getRoleNames()[0] == 'superadmin')
                                    <li class="list-group-item">{{ @$data->customer->no_telp }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
                @if ($user->getRoleNames()[0] == 'superadmin' || $user->getRoleNames()[0] == 'member')
                    <div class="card mb-3">
                        <div class="card-header text-capitalize">worker</div>
                        <div class="card-body p-0">
                            <ul class="list-group">
                                <li class="list-group-item">{{ @$data->customer->name }}</li>
                                <li class="list-group-item">{{ @$data->customer->alamat }}</li>
                                @if ($user->getRoleNames()[0] == 'superadmin')
                                    <li class="list-group-item">{{ @$data->customer->no_telp }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Detail Order</div>
                    <div class="card-body">
                    <ul class="list-group">
                         <li class="list-group-item">
                            <strong>Layanan:</strong> {{ @$data->layanan->title }}
                        </li>
                        <li class="list-group-item">
                            <strong>Harga Member:</strong> {{ @$data->layanan->harga_member }}
                        </li>
                        <li class="list-group-item">
                            <strong>Harga Worker:</strong> {{ @$data->layanan->harga_worker }}
                        </li>
                        <li class="list-group-item">
                            <strong>Nama Worker:</strong> {{ @$data->worker->name ?? 'Belum Ditugaskan' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Nama Member:</strong> {{ @$data->customer->name ?? 'Tidak Ada' }}
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
