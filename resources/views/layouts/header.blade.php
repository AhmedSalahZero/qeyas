<!DOCTYPE html>
<html lang="en" dir="rtl" data-token="{{ csrf_token() }}">
													{{-- {{ dd(\App\Category::all()) }} --}}
{{-- {{ dd(\App\Course::getCoursesTypes()) }} --}}
<head>
    <!-- Meta information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"><!-- Mobile Specific Metas -->

    <!-- Title -->
    <title>{{ config('app.name') . (@$title ? ' | ' . $title : '') }}</title>

    <!-- favicon icon -->
    <link rel="shortcut icon" href="{{ asset('images/Favicon.ico') }}">

    <!-- CSS Stylesheet -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"><!-- bootstrap css -->
    <link href="{{ asset('css/bootstrap-rtl.min.css') }}" rel="stylesheet"><!-- bootstrap rtl css -->
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet"><!-- carousel Slider -->
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet"><!-- font awesome -->
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet"><!--  loader css -->
    <link href="{{ asset('css/docs.css') }}" rel="stylesheet"><!--  template structure css -->
    <link href="{{ asset('css/jquery.countdown.css') }}" rel="stylesheet">
	
    <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:100,200,300,400,500,700,800,900%7CPT+Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Tajawal:500&display=swap" rel="stylesheet">
	<style>
	
	.q-img{
		width:250px !important;
	}
	.text-center{
		text-align:center;
	}
	paper-toast {
  z-index: 999999999999;
}
	.mb-2{
		margin-bottom:2rem;
	}
	</style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

										{{-- {{ dd($categories->last()->sub_categories) }} --}}
</head>

<body>
    <div class="wapper">
        <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
        </div>
        <div class="quck-nav">
            <div class="container">
                <div class="contact-no Tajawal-font">
                    @php($now = \Carbon\Carbon::now('Asia/Riyadh'))
                    <i class="fa fa-calendar"></i>
                    {{ $now->day }}
                    {{ $ar_month[$now->shortEnglishMonth] }}
                    {{ $now->year }}
					{{-- <br> --}}
					{{-- {{  }} --}}
                </div>
                <div class="quck-right">
                    @auth('web')
                        <div class="right-link Tajawal-font">
                            <a href="{{ route('user.notifications') }}">
                                <i class="fa fa-bell" aria-hidden="true"></i>إشعاراتي
                            </a>
                        </div>
                        <div class="right-link Tajawal-font">
                            <a href="{{ route('user.profile') }}">
                                <i class="fa fa-bell" aria-hidden="true"></i>حسابي
                            </a>
                        </div>
                        <div class="right-link Tajawal-font">
                            <form action="{{ route('logout') }}" method="post" class="form-inline">
                                {{ csrf_field() }}
                                <button type="submit" class="btn-sm btn-link" style="color: white;">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    خروج
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="right-link Tajawal-font"><a href="{{ route('login') }}"><i class="fa  fa-user"></i>دخول / إنشاء حساب</a></div>
                    @endauth
                </div>
            </div>
        </div>
        <header id="header">
            <div class="container">
                <nav id="nav-main">
                    <div class="navbar navbar-inverse">
                        <div class="navbar-header">
                            <a href="{{ route('home') }}" class="navbar-brand">
                                <img src="{{ asset('images/logo.png') }}" alt="">
                            </a>
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="sub-menu">
                                    <a class="Tajawal-font" href="{{ route('home') }}">الرئيسية</a>
                                </li>
                                <li class="sub-menu mega-menu">
                                    <a class="Tajawal-font" href="{{ route('about') }}">عن قياس2030</a>
                                </li>
                                <li class="mega-menu sub-menu">
                                    <a class="Tajawal-font" href="{{ route('categories.index') }}">إختبارات قياس</a>
                                    <div class="menu-view">
                                        <div class="row">
                                            @foreach($categories as $x=>$category)
											{{-- {{ dd($x) }} --}}
                                                @if($category->exam_count() == 0)
                                                    @continue
                                                @endif
                                                <div class="col-sm-3">
                                                    <div class="menu-title">
                                                        <a href="{{ route('categories.show', $category) }}">{{ $category->cat_name }}</a>
                                                    </div>
                                                    @if($category->sub_categories->count())
                                                        <ul>
                                                            @foreach($category->sub_categories as $sub_category)
                                                            {{-- @foreach($category->sub_categories->take(4) as $sub_category) --}}
                                                                @if($sub_category->exam_count() == 0)
                                                                    @continue
                                                                @endif
                                                                <li>
                                                                    <a class="Tajawal-font" href="{{ route('categories.show', $sub_category) }}">
                                                                        {{ $sub_category->cat_name }}
                                                                        <span class="muted-text" style="display: inline-block">
                                                                            ({{ $sub_category->exam_count() }} إختبار)
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                                <li class="sub-menu mega-menu">
									<a class="Tajawal-font" href="{{ route('courses.index') }}">الدورات التدريبية</a>
									<div class="menu-view ">
                                        <div class="row">
									
                                            @foreach(\App\Course::getCoursesTypes() as $courseTypeEn => $courseTypeAr )
													
													<?php
													$typeId = $courseTypeEn == 'recorded' ? 0 : 1 ;  
													$courses = \App\Course::where('type',$typeId)->where('active',1)->orderBy('order','asc')->get();
													?>
                                                <div class="col-sm-3">
                                                    <div class="menu-title">
                                                        <a href="{{ route('courses.show', $courseTypeAr) }}">{{ $courseTypeAr }}</a>
                                                    </div>
                                                    @if($courses->count())
                                                        <ul>
                                                            @foreach($courses->take(4) as $course)
                                                               
                                                                <li>
                                                                    <a class="Tajawal-font" href="{{ route('courses.show', $course->id ) }}">
                                                                        {{-- {{ $courseTypeEn }} --}}
                                                                            ({{ $course->getName() }} )
                                                                        {{-- <span class="muted-text" style="display: inline-block">
                                                                        </span> --}}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
									</li>
                                <li class="sub-menu mega-menu">
                                    <a class="Tajawal-font" href="{{ route('books.index') }}">الكتب الإلكترونية</a>
                                </li>
                                <li class="sub-menu mega-menu">
                                    <a class="Tajawal-font" href="{{ route('news.index') }}">أخبارنا</a>
                                </li>
                                <li class="sub-menu">
                                    <a class="Tajawal-font" href="{{ route('videos.index') }}">مكتبة الفيديو</a>
                                </li>
                                <li class="sub-menu">
                                    <a class="Tajawal-font" href="{{ route('contact') }}">تواصل معنا</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
