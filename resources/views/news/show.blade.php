@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img">
            <img src="{{ Voyager::image($news->photo) ?? asset('images/banner/register-bannerImg.jpg') }}" alt="">
        </div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">{{ $news->title }}</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('news.index') }}">أخبار قياس2030</a></li>
                <li>
                    <a href="{{ route('news.show', $news) }}" title="{{ $news->title }}">
                        {{ str_limit($news->title, 100) }}
                    </a>
                </li>
            </ul>
        </div>
    </section>
    <section>
        <div class="course-details">
            <div class="container">
                <h2 class="Tajawal-font">
                    {{ $news->title }}
                </h2>
                <div class="course-details-main">
                    <div class="course-img">
                        <img src="{{ Voyager::image($news->photo) ?? asset('images/banner/register-bannerImg.jpg') }}" alt="">
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="course-instructorInfo">
                                <span class="box news-date">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    {{ $news->news_date->format('d'). ' ' .
                                     $ar_month[$news->news_date->format('M')] . ' ' .
                                     $news->news_date->format('Y') }}
                                </span>
                                <span class="box news-seen">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    {{ $news->num_watches }} مشاهدة
                                </span>
                                <a href="#">
                                    <span class="box news-like"><i class="fa fa-thumbs-up" aria-hidden="true"></i>   {{ $news->likes }} إعجاب</span>
                                </a>
                                <a href="#">
                                    <span class="box news-dislike"><i class="fa fa-thumbs-down" aria-hidden="true"></i>   {{ $news->dislikes }} عدم إعجاب</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="info">
                    <h4 class="Tajawal-font">تفاصيل الخبر</h4>
                    <p>{!! $news->content !!}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
