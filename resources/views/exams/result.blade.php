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
                <h2 class="Tajawal-font">تهانينا!</h2>
                <p>لقد تم إكمال الإختبار بنجاح</p>
            </div>
            <div class="row">
                {{--<div class="col-sm-4 col-md-3">--}}
                    {{--<div id="countdown_stop"></div>--}}
                    {{--<div class="qustion-list">--}}
                        {{--<div class="qustion-slide fill">--}}
                            {{--<div class="qustion-number">Question 1</div>--}}
                            {{--<span>2</span>--}}
                        {{--</div>--}}
                        {{--<div class="qustion-slide active">--}}
                            {{--<div class="qustion-number">Question 2</div>--}}
                            {{--<span>2</span>--}}
                        {{--</div>--}}
                        {{--<div class="qustion-slide">--}}
                            {{--<div class="qustion-number">Question 3</div>--}}
                            {{--<span>2</span>--}}
                        {{--</div>--}}
                        {{--<div class="qustion-slide">--}}
                            {{--<div class="qustion-number">Question 4</div>--}}
                            {{--<span>2</span>--}}
                        {{--</div>--}}
                        {{--<div class="qustion-slide">--}}
                            {{--<div class="qustion-number">Question 5</div>--}}
                            {{--<span>2</span>--}}
                        {{--</div>--}}
                        {{--<div class="qustion-slide">--}}
                            {{--<div class="qustion-number">Question 6</div>--}}
                            {{--<span>2</span>--}}
                        {{--</div>--}}
                        {{--<div class="qustion-slide">--}}
                            {{--<div class="qustion-number">Question 7</div>--}}
                            {{--<span>2</span>--}}
                        {{--</div>--}}
                        {{--<div class="qustion-slide">--}}
                            {{--<div class="qustion-number">Question 8</div>--}}
                            {{--<span>2</span>--}}
                        {{--</div>--}}
                        {{--<div class="qustion-slide">--}}
                            {{--<div class="qustion-number">Question 9</div>--}}
                            {{--<span>2</span>--}}
                        {{--</div>--}}
                        {{--<div class="qustion-slide">--}}
                            {{--<div class="qustion-number">Question 10</div>--}}
                            {{--<span>2</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="col-sm-8 col-md-9">
                    <div class="quiz-result">
                        <h3 class="Tajawal-font">تفاصيل النتيجة</h3>
                        <div class="result-info">
                            <div class="info-slide">
                                <p>النتيجة<span>{{ $percentage }}%</span></p>
                            </div>
                            <div class="info-slide">
                                <p>الوقت المنقضي<span>{{ $time_spent }}</span></p>
                            </div>
							{{-- {{ dd($exam->exam) }} --}}
							  <div class="info-slide">
                                <p><i class="fa fa-check" aria-hidden="true"></i>    
									اجمالي عدد الأسئلة
								<span> {{ $totalQuestionNumber }} أسئلة</span></p>
                            </div>
                            <div class="info-slide">
                                <p><i class="fa fa-check" aria-hidden="true"></i>    عدد الأسئلة الصحيحة<span> {{ $right_answers }} أسئلة</span></p>
                            </div>
                            <div class="info-slide">
                                <p><i class="fa fa-times" aria-hidden="true"></i>    عدد الأسئلة الخاطئة<span>{{ $wrong_answers }} أسئلة</span></p>
                            </div>
							
							<div class="info-slide">
                                <p><i class="fa fa-times" aria-hidden="true"></i>    عدد الأسئلة التي لم يتم الاجابه عليها<span>
								{{ $totalQuestionNumber - ($right_answers+$wrong_answers) }}
								
								 أسئلة</span></p>
                            </div>
							
                            <div class="toplist-btn">
                                <a href="{{ route('user.profile',['prev_exams'=>1]) }}" class="btn">نتائج الاختبارات السابقة</a>
                                {{-- <a href="{{ route('exams.toplist', $exam) }}" class="btn">نتائج الاختبارات السابقة</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
