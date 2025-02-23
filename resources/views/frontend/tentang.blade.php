@extends('layouts.frontend')

@section('content')
    <!-- common banner -->
    <section class="common-banner">
        <div class="bg-layer" style="background: url('{{ asset('assets/images/background/common-banner-bg.jpg')}}');"></div>
        <div class="common-banner-content">
            <h3>Tentang Kami</h3>
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item active"><a href="{{ url('/')}}">Beranda</a></li>
                    <li class="breadcrumb-item"><i class="fa-solid fa-angles-right"></i> tentang</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- common banner -->


    <!-- about page -->
    <section class="about-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="about-page-left">
                        <div class="yellow-shape"></div>
                        <div class="pink-shape"></div>
                        <div class="about-counter">
                            <div class="bg-layer" style="background: url('{{ asset('assets/images/background/about-counter.png') }}');">
                            </div>
                            <div class="about-counter-imag">
                                <img src="{{ asset('assets/images/resource/about-page-2.png') }}" alt="image">
                            </div>
                            <div class="about-counter-content">
                                <h3>5+</h3>
                                <p>Tahun Pengalaman</p>
                            </div>
                        </div>
                        <div class="about-page-left-image">
                            <img src="{{ asset('assets/images/resource/about-page-1.jpg') }}" alt="image">
                            <div class="about-shape">
                                <img src="{{ asset('assets/images/shape/about-1.png') }}" alt="shape">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="rewards-left-container">
                        <div class="rewards-left-container-inner">
                            <div class="common-title mb_30">
                                <h6><i class="fa-solid fa-angles-right"></i> TENTANG PERUSAHAAN</h6>
                                <h3>Solusi Terbaik untuk Berbagai Jenis Layanan</h3>
                                <p>Kami menyediakan layanan profesional dengan paket lengkap dan harga tetap yang dirancang untuk memenuhi kebutuhan Anda.</p>
                            </div>
                            <div class="rewards-left-list">
                                <ul>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i> Akses gratis ke ribuan peluang kerja</li>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i> Kembangkan bisnis dan basis klien Anda</li>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i> Dapatkan penghasilan tambahan dengan jadwal fleksibel</li>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i> Tanpa biaya berlangganan atau kredit</li>
                                </ul>
                            </div>
                            <div class="reward-btn">
                                <a href="{{ url('/layanan') }}" class="btn-1">Telusuri Lebih Lanjut <i class="icon-arrow-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about page -->

    <!-- contact section -->
<section class="contact-section bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="contact-content position-relative">
                    <div class="common-title mb-4">
                        <h6><i class="fa-solid fa-angles-right"></i> HUBUNGI KAMI</h6>
                        <h3>Butuh Bantuan? Hubungi Kami</h3>
                        <p>Kami siap membantu Anda dengan solusi terbaik untuk setiap kebutuhan.</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ url('/kontak') }}" class="btn-1">Hubungi Kami <i class="icon-arrow-1"></i></a>
                    </div>
                    <!-- Decorative elements -->
                    <div class="yellow-shape position-absolute" style="top: -20px; right: -20px; width: 100px; height: 100px; background-color: #ffd700; opacity: 0.2; border-radius: 50%;"></div>
                    <div class="pink-shape position-absolute" style="bottom: -30px; left: -30px; width: 150px; height: 150px; background-color: #ff69b4; opacity: 0.1; border-radius: 50%;"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-image position-relative">
                    <img src="{{ asset('assets/images/resource/contact.jpg') }}" alt="contact" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact section  -->
@endsection
