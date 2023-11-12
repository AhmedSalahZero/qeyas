@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">قائمة الأفضل</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                {{--<li><a href="login-register.html">الإختبارات التعليمية</a></li>--}}
                {{--<li><a href="login-register.html">قدرات (1)</a></li>--}}
                {{--<li><a href="login-register.html">مفاهيم عامة</a></li>--}}
                <li>قائمة الأفضل</li>
            </ul>
        </div>
    </section>
    <div class="event-page">
        <div class="container">
            <div class="section-title">
                <h2 class="Tajawal-font">قائمة الأفضل</h2>
                <p>أعلى 10 مراكز حصل عليها الطلاب في اختبار {{ $exam->title }}</p>
            </div>
            <div class="row">
                @foreach($top_students as $student)
                    <div class="col-sm-6 col-md-4">
                        <div class="event-box">
                            <div class="price">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <span>{{ $loop->index + 1 }}</span>
                            </div>
                            <div class="img text-center">
                                <img src="{{ Voyager::image($student->user->avatar, asset('images/event/img1.jpg')) }}" alt="">
                            </div>
                            <div class="event-name"><a href="#">{{ $student->user->name }}</a></div>
                            <div class="event-info"><i class="fa fa-clock-o"></i> {{ $student->time_spent }} دقيقة</div>
                            <?php  if(!empty($student->user->user_city)){ ?>
                            <div class="event-info"><i class="fa fa-map-marker"></i>{{ $student->user->user_city->city_name }}</div>
                          <?php } ?>
                            <div class="event-info"><i class="fa fa-percent"></i>{{ $student->highest_result }}</div>
                        </div>
                    </div>
                @endforeach
                {{--<div class="col-sm-6 col-md-4">--}}
                    {{--<div class="event-box">--}}
                        {{--<div class="price">--}}
                            {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                            {{--<span>1</span>--}}
                        {{--</div>--}}
                        {{--<div class="img text-center"><img src="images/event/img1.jpg" alt=""></div>--}}
                        {{--<div class="event-name"><a href="#">محمد احمد احمد</a></div>--}}
                        {{--<div class="event-info"><i class="fa fa-clock-o"></i> 15:22:10 دقيقة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-map-marker"></i>المنصورة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-percent"></i>80%</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-6 col-md-4">--}}
                    {{--<div class="event-box">--}}
                        {{--<div class="price">--}}
                            {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                            {{--<span>1</span>--}}
                        {{--</div>--}}
                        {{--<div class="img text-center"><img src="images/event/img1.jpg" alt=""></div>--}}
                        {{--<div class="event-name"><a href="#">محمد احمد احمد</a></div>--}}
                        {{--<div class="event-info"><i class="fa fa-clock-o"></i> 15:22:10 دقيقة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-map-marker"></i>المنصورة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-percent"></i>80%</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-6 col-md-4">--}}
                    {{--<div class="event-box">--}}
                        {{--<div class="price">--}}
                            {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                            {{--<span>1</span>--}}
                        {{--</div>--}}
                        {{--<div class="img text-center"><img src="images/event/img1.jpg" alt=""></div>--}}
                        {{--<div class="event-name"><a href="#">محمد احمد احمد</a></div>--}}
                        {{--<div class="event-info"><i class="fa fa-clock-o"></i> 15:22:10 دقيقة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-map-marker"></i>المنصورة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-percent"></i>80%</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-6 col-md-4">--}}
                    {{--<div class="event-box">--}}
                        {{--<div class="price">--}}
                            {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                            {{--<span>1</span>--}}
                        {{--</div>--}}
                        {{--<div class="img text-center"><img src="images/event/img1.jpg" alt=""></div>--}}
                        {{--<div class="event-name"><a href="#">محمد احمد احمد</a></div>--}}
                        {{--<div class="event-info"><i class="fa fa-clock-o"></i> 15:22:10 دقيقة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-map-marker"></i>المنصورة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-percent"></i>80%</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-6 col-md-4">--}}
                    {{--<div class="event-box">--}}
                        {{--<div class="price">--}}
                            {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                            {{--<span>1</span>--}}
                        {{--</div>--}}
                        {{--<div class="img text-center"><img src="images/event/img1.jpg" alt=""></div>--}}
                        {{--<div class="event-name"><a href="#">محمد احمد احمد</a></div>--}}
                        {{--<div class="event-info"><i class="fa fa-clock-o"></i> 15:22:10 دقيقة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-map-marker"></i>المنصورة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-percent"></i>80%</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
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
        </div>
    </div>
@endsection
