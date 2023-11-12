@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">{{ $page->title }}</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li>{{ $page->title }}</li>
            </ul>
        </div>
    </section>
    <section class="about-page">
        <section class="about-target-audience">
            <div class="container">
                <div class="section-title">
                    <h2 class="Tajawal-font">{{ $page->title }}</h2>
                </div>
                <div class="row">
                    {!! $page->content !!}
                </div>
            </div>
        </section>
    </section>
@endsection
