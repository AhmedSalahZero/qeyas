@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">أخبار قياس2030</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('news.index') }}">أخبار قياس2030</a></li>
            </ul>
        </div>
    </section>
    <section class="news-section">
        <div class="courses-view list-view">
            <div class="container">
                @if(count($news))
                    @foreach($news as $_news)
                        <div class="course-post">
                            <div class="img">
                                <img src="{{ Voyager::image("$_news->photo") }}" alt="">
                                <div class="icon">
                                    <a href="{{ route('news.show', $_news->id) }}">
                                        <img src="{{ asset('images/book-icon.png') }}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="info">
                                <div class="name Tajawal-font">
                                    {{ $_news->title }}
                                </div>
                                <div class="product-footer">
                                    <div class="comment-box">
                                        <span class="box news-date Tajawal-font">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            {{ $_news->news_date->format('d'). ' ' .
                                             $ar_month[$_news->news_date->format('M')] . ' ' .
                                             $_news->news_date->format('Y') }}
                                        </span>
                                        <span class="box news-seen">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            {{ $_news->num_watches }} مشاهدة
                                        </span>
                                        <span class="box news-like">
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                            {{ $_news->likes }} إعجاب
                                        </span>
                                        <span class="box news-dislike">
                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                            {{ $_news->dislikes }} عدم إعجاب
                                        </span>
                                    </div>

                                    <p>{{ str_limit($_news->content) }}</p>
                                    <div class="view-btn2">
                                        <a href="{{ route('news.show', $_news->id) }}" class="btn">مشاهدة المزيد</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                {{--<div class="pagination">--}}
                    {{--<ul>--}}
                        {{--<li class="next"><a href="#"><i class="fa fa-angle-right"></i><span>Next</span></a></li>--}}
                        {{--<li class="active"><a href="#">1</a></li>--}}
                        {{--<li><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#">4</a></li>--}}
                        {{--<li class="prev"><a href="#"><span>prev</span> <i class="fa fa-angle-left"></i></a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                {{ $news->links() }}
            </div>
        </div>
    </section>
@endsection
