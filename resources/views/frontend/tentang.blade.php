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
                                <h3>12+</h3>
                                <p>Years of Experiences</p>
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
                                <h6><i class="fa-solid fa-angles-right"></i> ABOUT COMPANY</h6>
                                <h3>Best Solution For Different Type Services</h3>
                                <p>Our Professional Website Setup service offers a comprehensive, fixed-price package
                                    designed .</p>
                            </div>
                            <div class="rewards-left-list">
                                <ul>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i> Free access to thousands of job
                                        opportunities</li>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i> Grow your business and client base
                                    </li>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i> Earn extra income on a flexible
                                        schedule</li>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i> No subscription or credit fees
                                    </li>
                                </ul>
                            </div>
                            <div class="reward-btn">
                                <a href="service-details.html" class="btn-1">More Details <i class="icon-arrow-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about page -->
@endsection
