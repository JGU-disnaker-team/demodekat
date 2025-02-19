@extends('layouts.frontend')

@section('content')
    <!-- common banner -->
    <section class="common-banner">
        <div class="bg-layer" style="background: url('{{ asset('assets/images/background/common-banner-bg.jpg') }}');"></div>
        <div class="common-banner-content">
            <h3>Pesan Layanan</h3>
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item active"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><i class="fa-solid fa-angles-right"></i> Pesan Layanan</li>
                </ul>
            </div>
        </div>
    </section>
    <section class=" service-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="common-title">
                        <h4>{{ $data->title}}</h4>
        
                    </div>
                    <div class="ratio ratio-16x9 mb-4"
                        style="background-image: url('{{ $data->image_url }}');background-repeat: no-repeat;
                        background-size: cover;">

                    </div>
                    <div class="service-details-content">
                        <h4>Service Details</h4>
                        {!! $data->konten !!}
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="contact-form">
                        <h3>Pesan Layanan</h3>
                        <form method="POST" action="{{ url('send_order') }}">
                            @csrf
                            <input type="hidden" name="layanan_id" value="{{ $data->id}}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Tanggal Layanan</label>
                                    <input type="date" class="cmn-input" name="waktu" value="{{ old('waktu') }}"
                                        required placeholder="waktu Lengkap" min="{{date('Y-m-d')}}" max="{{date('Y-m-d', strtotime('+2 days'))}}">
                                </div>
                                <div class="col-lg-6">
                                    
                                    <div class="form-group mb-3">
                                        <label>Jam Layanan</label>
                                        {{ Form::select('jam', jam_layanan(), null, ['class' => 'form-select']) }}
                                        @if ($errors->first('jam'))
                                            <small class="text-danger text-capitalize">{{ $errors->first('jam') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Nomor Yang bisa di hubungi</label>
                                    <input type="text" class="cmn-input" name="no_telp" value="{{ Auth::user()->no_telp }}"
                                        required placeholder="+62 xxxx xxxx xxxx ">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Alamat Lengkap</label>
                                    <textarea class="cmn-input" name="alamat" required>{{ Auth::user()->alamat }}</textarea>
                                    <div class="checkbox-input">
                                        <input type="checkbox" class="form-check-input" id="term" required>
                                        <label for="term">Data Yang saya kirim adalah data yang sebenarnya dari
                                            saya</label>
                                    </div>
                                    <button type="submit" class="btn-1">Pesan Sekarang<i class="icon-arrow-1"></i></button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- common banner -->
@endsection
