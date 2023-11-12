@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">مكتبة الفيديو</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('videos.index') }}">مكتبة الفيديو</a></li>
                <li><a href="{{ route('videos.show', $video) }}">تفاصيل الفيديو</a></li>
            </ul>
        </div>
    </section>
    <div class="blog-page blog-details">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="blog-slide">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $video->video_id }}" allowfullscreen></iframe>
                        </div>
                        <div class="info">
                            <div class="name">{{ $video->video_title }}</div>
                            <div class="post-info">
                                <span><i class="fa fa-eye" aria-hidden="true"></i>{{ $video->video_num_watches }} مشاهدة</span>
                                <span><i class="fa fa-calendar" aria-hidden="true"></i>{{ $video->date }}</span>
                            </div>
                            <p>{{ $video->video_description }}</p>
                            <div class="blog-bottom">
                                <ul class="sosiyal-mediya">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                </ul>
                            </div>
                            <!-- AddToAny BEGIN -->
                            <!-- <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                            <a class="a2a_button_facebook"></a>
                            <a class="a2a_button_twitter"></a>
                            <a class="a2a_button_linkedin"></a>
                            <a class="a2a_button_google_gmail"></a>
                            </div>
                            <script async src="https://static.addtoany.com/menu/page.js"></script> -->
                            <!-- AddToAny END -->
                        </div>
                    </div>
                </div>
                {{--<div class="col-md-4">--}}
                    {{--<div class="right-slide">--}}
                        {{--<div class="search-box">--}}
                            {{--<input type="text" placeholder="Search">--}}
                            {{--<input type="submit" value="">--}}
                        {{--</div>--}}
                        {{--<h3>Catagories</h3>--}}
                        {{--<ul class="catagorie-list">--}}
                            {{--<li><a href="#">Computer Sciences</a></li>--}}
                            {{--<li><a href="#">Business & Management</a></li>--}}
                            {{--<li><a href="#">Biology & Life Sciences</a></li>--}}
                            {{--<li><a href="#">Software Engineering</a></li>--}}
                            {{--<li><a href="#">Music, Film And Audio</a></li>--}}
                        {{--</ul>--}}
                        {{--<h3>Recent Posts</h3>--}}
                        {{--<div class="recent-post">--}}
                            {{--<div class="post-slide">--}}
                                {{--<div class="img"><img src="images/blog/post-img1.jpg" alt=""></div>--}}
                                {{--<p><a href="#">when an unknown printer took a galley of type and scrambled</a></p>--}}
                                {{--<div class="date">12 Jan</div>--}}
                            {{--</div>--}}
                            {{--<div class="post-slide">--}}
                                {{--<div class="img"><img src="images/blog/post-img2.jpg" alt=""></div>--}}
                                {{--<p><a href="#">when an unknown printer took a galley of type and scrambled</a></p>--}}
                                {{--<div class="date">12 Jan</div>--}}
                            {{--</div>--}}
                            {{--<div class="post-slide">--}}
                                {{--<div class="img"><img src="images/blog/post-img3.jpg" alt=""></div>--}}
                                {{--<p><a href="#">when an unknown printer took a galley of type and scrambled</a></p>--}}
                                {{--<div class="date">12 Jan</div>--}}
                            {{--</div>--}}
                            {{--<div class="post-slide">--}}
                                {{--<div class="img"><img src="images/blog/post-img1.jpg" alt=""></div>--}}
                                {{--<p><a href="#">when an unknown printer took a galley of type and scrambled</a></p>--}}
                                {{--<div class="date">12 Jan</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<h3>Archive</h3>--}}
                        {{--<ul class="catagorie-list">--}}
                            {{--<li><a href="#">October 2001</a></li>--}}
                            {{--<li><a href="#">November 2014</a></li>--}}
                            {{--<li><a href="#">December 2015</a></li>--}}
                            {{--<li><a href="#">January 2016</a></li>--}}
                            {{--<li><a href="#">February 2016</a></li>--}}
                        {{--</ul>--}}
                        {{--<h3>Keywords</h3>--}}
                        {{--<ul class="keyword-list">--}}
                            {{--<li><a href="#">Html</a></li>--}}
                            {{--<li><a href="#">Boostrap</a></li>--}}
                            {{--<li><a href="#">Css3</a></li>--}}
                            {{--<li><a href="#">Jquery</a></li>--}}
                            {{--<li><a href="#">Student</a></li>--}}
                            {{--<li><a href="#">Html</a></li>--}}
                            {{--<li><a href="#">Boostrap</a></li>--}}
                            {{--<li><a href="#">Css3</a></li>--}}
                            {{--<li><a href="#">Jquery</a></li>--}}
                            {{--<li><a href="#">Student</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection