@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">نتيجة الاختبار</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('exams.show', $exam) }}">تعليمات قبل الاختبار</a></li>
                {{--<li><a href="quiz.html">الاختبار</a></li>--}}
                <li>نتيجة الإختبار</li>
            </ul>
        </div>
    </section>
    <section class="quiz-view">
        <div class="container">
            <div class="result-msg">
                <h2 class="Tajawal-font">خطأ!</h2>
                <p class="alert alert-danger">لم يتم الاجابة على اي سؤال .. من فضلك <a href="{{ route('exams.start', $exam) }}">اعد المحاولة</a></p>
            </div>
        </div>
    </section>
@endsection