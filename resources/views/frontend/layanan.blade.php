@extends('layouts.frontend')

@section('content')
    <!-- common banner -->
    <section class="common-banner">
        <div class="bg-layer" style="background: url('assets/images/background/common-banner-bg.jpg');"></div>
        <div class="common-banner-content">
            <h3>Layanan kami</h3>
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item active"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><i class="fa-solid fa-angles-right"></i> Layanan</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- common banner -->


    <!-- service page -->
    <section class="service-page">
        <div class="container">
            <form>
                <div class="row">
                    <div class="col-lg-3">
                        <form action="#">
                            <div class="sidebar">
                                <div class="sidebar-top-title">
                                    <h4>Filter by</h4>
                                </div>
                            </div>

                            <div class="sidebar-box">
                                <div class="sidebar-title">
                                    <h5>Cari</h5>
                                </div>
                                <div class="keyword-input">
                                    <input type="text" name="cari" value="{{ $cari}}" placeholder="Tukang AC">
                                </div>
                            </div>

                            <div class="sidebar-box">
                                <div class="categories-content sidebar-title">
                                    <h5>
                                        <button class="btn" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            <span>Kategori</span><i class="fa-regular fa-angle-down"></i>
                                        </button>
                                    </h5>
                                    <div class="collapse show" id="collapseExample">
                                        <div class="card card-body">
                                            <div class="categories-list">
                                                <ul>
                                                    @forelse($kategori_all as $kat)
                                                        <li>
                                                            <div class="checkbox-input">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="kategori[]" value="{{ $kat->id }}"
                                                                    id="{{ $kat->id }}" {{ !empty($kategori)? (in_array($kat->id,$kategori) ? 'checked':''):""}}>
                                                                <label
                                                                    for="{{ $kat->id }}">{{ $kat->title }}</label>
                                                            </div>
                                                        </li>
                                                    @empty
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="sidebar-button">
                                <button type="submit" class="btn-1 w-100"><i class="fa-solid fa-magnifying-glass"></i>
                                    Cari Sekarang</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-9">
                        <div class="service-item-container">

                            <div class="row">
                                @forelse($layanan_all as $layanan)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="featured-single">
                                            <div class="featured-single-image">
                                                <a href="{{ url('layanan/' . $layanan->id) }}">
                                                    <img src="{{ $layanan->image_url }}" class="w-100" alt="image">
                                                </a>
                                            </div>
                                            <div class="featured-single-wishlist">
                                                <h6>{{ @$layanan->kategori->title}}</h6>
                                            </div>
                                            <div class="featured-single-content">

                                                <a href="{{ url('layanan/' . $layanan->id) }}">{{ $layanan->title }} </a>
                                                <div class="featured-single-info">
                                                    <div class="featured-single-info-left">
                                                        <h5>Rp.{{ formating_number($layanan->harga_member, 0) }}</h5>
                                                    </div>
                                                    <a href="{{ url('pesan/' . $layanan->id) }}">Pesan Sekarang</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12">
                                        <div class="alert alert-warning mt-5">
                                            <div class="alert-body">Data Yang anda cari tidak Ditemukan</div>
                                        </div>
                                    </div>
                                    
                                @endforelse

                                <div class="col-lg-12">
                                    <div class="paigination">
                                        {{ $layanan_all->appends(request()->all())->links('vendor.pagination.bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- service page -->
@endsection
