@extends('layouts.app')

@section('content')
@if($exam->isEnglish())
<style>
    .quiz-intro * 
	{
        text-align: left;
    }
</style>
@endif
<section class="banner inner-page">
    <div class="banner-img">
        <img src="{{ Voyager::image($exam->icon_url, asset('images/banner/register-bannerImg.jpg')) }}" alt="">
    </div>
    <div class="page-title">
        <div class="container">
            <h1 class="Tajawal-font exam-instruction">
                تعليمات مهمة
             
            </h1>
        </div>
    </div>
</section>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{ route('categories.show', $exam->category) }}">القسم الفرعي</a></li>
            <li>تعليمات قبل الاختبار</li>
        </ul>
    </div>
</section>
<section class="quiz-view">
    <div class="container">
        <div class="quiz-title">
            <h2 class="Tajawal-font">مفاهيم عامة</h2>
            <p>معلومات عن الاختبار </p>
        </div>
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <div class="time-info">الوقت الكلي</div>
                <div id="countdown_stop" style="direction: ltr;"></div>
                <div class="qustion-list">
                    @foreach($exam->sections as $section)
                    <div class="qustion-slide">
                        <div class="qustion-number">{{ $section->section_title }}</div>
                        <span>{{ $section->questions->count() }}</span>
                    </div>
                    @endforeach
                    {{--<div class="qustion-slide">--}}
                    {{--<div class="qustion-number">القسم الثاني</div>--}}
                    {{--<span>2</span>--}}
                    {{--</div>--}}
                    {{--<div class="qustion-slide">--}}
                    {{--<div class="qustion-number">القسم الثالث</div>--}}
                    {{--<span>2</span>--}}
                    {{--</div>--}}
                    {{--<div class="qustion-slide">--}}
                    {{--<div class="qustion-number">القسم الرابع</div>--}}
                    {{--<span>2</span>--}}
                    {{--</div>--}}
                    {{--<div class="qustion-slide">--}}
                    {{--<div class="qustion-number">القسم الخامس</div>--}}
                    {{--<span>2</span>--}}
                    {{--</div>--}}
                    {{--<div class="qustion-slide">--}}
                    {{--<div class="qustion-number">القسم السادس</div>--}}
                    {{--<span>2</span>--}}
                    {{--</div>--}}
                    {{--<div class="qustion-slide">--}}
                    {{--<div class="qustion-number">القسم السابع</div>--}}
                    {{--<span>2</span>--}}
                    {{--</div>--}}
                    {{--<div class="qustion-slide">--}}
                    {{--<div class="qustion-number">القسم الثامن</div>--}}
                    {{--<span>2</span>--}}
                    {{--</div>--}}
                    {{--<div class="qustion-slide">--}}
                    {{--<div class="qustion-number">القسم العاشر</div>--}}
                    {{--<span>2</span>--}}
                    {{--</div>--}}
                    {{--<div class="qustion-slide">--}}
                    {{--<div class="qustion-number">القسم العاشر</div>--}}
                    {{--<span>2</span>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="col-sm-8 col-md-9">
                <div class="quiz-intro">
                    <h3 class="Tajawal-font">تعليمات</h3>
                    <p>{{ $exam->getInstructions() }}</p>
                    <div class="start-btn">
                        <a href="{{ route('exams.start', $exam) }}" class="btn">ابدأ الإختبار</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/jquery.countdown.js') }}"></script>
<script>
    let minutes = parseInt("{{ $exam->exam_duration }}");

    $('#countdown_stop').countdown({
        timestamp: new Date().getTime() + minutes * 60 * 1000,
        // callback: function(){
        //     let now = new Date().getTime();
        //     console.log(this.timestamp + "\n");
        //     console.log(now);
        //     if (now > this.timestamp){
        //         alert('timer ends');
        //         this.stopeed = true;
        //     }
        // },
        stopeed: true
    });

</script>
@endsection
