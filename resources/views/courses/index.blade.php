@extends('layouts.app')

@section('content')
<style>
    .reset-link {
        text-decoration: none;
        color: inherit;
    }

</style>
<?php 
$isRecorded = in_array('مسجلة',Request()->segments()) ;
$isLive = in_array('مباشرة',Request()->segments()) ;

?>
<section class="banner inner-page">
    <div class="banner-img">
        <img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt="">
    </div>
    <div class="page-title">
        <div class="container">
            <h1 class="Tajawal-font">
                الدورات التدريبة
                @if($isRecorded)
				<br>
				(مسجله)
                @elseif($isLive)
				<br>
				(مباشره)
                @endif
            </h1>
        </div>
    </div>
</section>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{ route('home') }}">الرئيسية</a></li>
            @if(!$isLive && !$isRecorded)
            <li>الدورات التدريبية</li>
            @endif
            @if($isRecorded)
            <li><a href="{{ route('courses.index') }}">الدورات التدريبية</a></li>
            <li>مسجله</li>
            @elseif($isLive)
            <li><a href="{{ route('courses.index') }}">الدورات التدريبية</a></li>
            <li>مباشره</li>
            @endif
        </ul>
    </div>
</section>
<section class="courses-view list-view">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="right-slide left">
                    <form action="{{ route('courses.search') }}" method="get">
                        <h3 class="Tajawal-font">السعر</h3>
                        <div class="filter-blcok">
                            <div class="check-slide">
                                <label class="label_check" for="free">
                                    <input id="free" name="free_course" value="1" type="checkbox">
                                    مجاني
                                </label>
                            </div>
                            <div class="check-slide">
                                <label class="label_check" for="paid">
                                    <input id="paid" name="paid_course" value="1" type="checkbox">
                                    مدفوع
                                </label>
                            </div>
							@if($isLive )
							<input type="hidden" name="type" value="1">
							@elseif($isRecorded)
							<input type="hidden" name="type" value="0">
							@endif 
                            <button type="submit" class="btn">بحث</button>
                        </div>
                        {{--<h3 class="Tajawal-font">اللغة</h3>--}}
                        {{--<div class="filter-blcok">--}}
                        {{--<div class="check-slide">--}}
                        {{--<label class="label_check" for="checkbox-03"><input id="checkbox-03" type="checkbox"> العربية</label>--}}
                        {{--</div>--}}
                        {{--<div class="check-slide">--}}
                        {{--<label class="label_check" for="checkbox-04"><input id="checkbox-04" type="checkbox"> الإنجليزية</label>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </form>
                    {{--<h3 class="Tajawal-font">دورات ذات صلة</h3>--}}
                    {{--<div class="recent-post">--}}
                    {{--<div class="post-slide">--}}
                    {{--<div class="img"><img src="images/blog/post-img1.jpg" alt=""></div>--}}
                    {{--<p><a href="#">هذا النص هو مثال لنص يمكن أن يستبدل في نفس--}}
                    {{--المساحة،</a></p>--}}
                    {{--<div class="date">$200</div>--}}
                    {{--</div>--}}
                    {{--<div class="post-slide">--}}
                    {{--<div class="img"><img src="images/blog/post-img2.jpg" alt=""></div>--}}
                    {{--<p><a href="#">هذا النص هو مثال لنص يمكن أن يستبدل في نفس--}}
                    {{--المساحة،</a></p>--}}
                    {{--<div class="date">مجاني</div>--}}
                    {{--</div>--}}
                    {{--<div class="post-slide">--}}
                    {{--<div class="img"><img src="images/blog/post-img3.jpg" alt=""></div>--}}
                    {{--<p><a href="#">هذا النص هو مثال لنص يمكن أن يستبدل في نفس--}}
                    {{--المساحة،</a></p>--}}
                    {{--<div class="date Tajawal-font">$78</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--<h3 class="Tajawal-font">كلمات ذات صلة</h3>--}}
                    {{--<ul class="keyword-list">--}}
                    {{--<li><a href="#">قدرات</a></li>--}}
                    {{--<li><a href="#">تجريبي</a></li>--}}
                    {{--<li><a href="#">تعليمي</a></li>--}}
                    {{--<li><a href="#">رياضيات</a></li>--}}
                    {{--<li><a href="#">مفاهيم</a></li>--}}
                    {{--</ul>--}}
                </div>
            </div>
            <div class="col-md-9">
                <div class="filter-row">
                    <div class="search">
                        <form action="{{ route('courses.search') }}" method="get">
                            <input type="text" placeholder="البحث">
                            <input type="submit" value="">
                        </form>
                    </div>
                </div>
                @foreach($courses as $course)
                <div class="course-post">
                    <div class="img">
                        <img src="{{ Voyager::image($course->course_photo) }}" alt="">
                        <div class="icon">
                            <a href="{{ route('courses.show', $course) }}">
                                <img src="{{ asset('images/book-icon.png') }}" alt="">
                            </a>
                        </div>
                        <div class="price {{ $course->course_price == 0 ? 'free' : '' }} Tajawal-font">{{ $course->course_price == 0 ? 'مجاني' : $course->course_price . ' ' . getMainCurrency() }}</div>
                    </div>
                    <div class="info">
                        <div class="name Tajawal-font">{{ $course->course_title }}</div>
                        <div class="product-footer">
                            <div class="comment-box">
                                <div class="info-slide">
                                    <i class="fa fa-user-secret" title="المدربين"></i>
                                    @foreach($course->trainers as $trainer)
                                    {{ $trainer->trainer_name }} {{ $loop->last ? "" : '-' }}
                                    @endforeach
                                </div>
                                <br>
                                <div class="info-slide">
                                    <i class="fa fa-book" title="{{ $course->getType() }}"></i>
                                    <a href="{{ route('courses.show',$course->getType()) }}" class="reset-link">
                                        {{ $course->getType() }}
                                    </a>
                                </div>
                                <br>
                                <div class="date"><i class="fa fa-clock-o"></i>{{ $course->hours }} ساعة</div>
                                <div class="info-slide"><i class="fa fa-calendar"></i>{{ $course->start }} - {{ $course->end }}</div>
                            </div>
                            {{-- <p>{{ $course->getType() }}</p> --}}
                            <p>{{ str_limit($course->course_description, 300) }}</p>
                            <div class="view-btn2">
                                <a href="{{ route('courses.show', $course) }}" class="btn2">التفاصيل</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
