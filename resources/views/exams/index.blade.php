@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">إختبارات قياس</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li>إختبارات قياس</li>
            </ul>
        </div>
    </section>
    <section class="courses-view list-view">
        <div class="container">
            @if(count($exams))
                <div class="row">
                    <div class="col-md-3 hidden-xs hidden-sm">
                        <div class="right-slide left">
                            <h3 class="Tajawal-font">نوع الإختبار</h3>
                            <div class="filter-blcok">
                                <div class="check-slide">
                                    <label class="label_check" for="checkbox-01"><input id="checkbox-01" type="checkbox"> مجاني</label>
                                </div>
                                <div class="check-slide">
                                    <label class="label_check" for="checkbox-02"><input id="checkbox-02" type="checkbox"> مدفوع</label>
                                </div>
                            </div>
                            <h3 class="Tajawal-font">اللغة</h3>
                            <div class="filter-blcok">
                                <div class="check-slide">
                                    <label class="label_check" for="checkbox-03"><input id="checkbox-03" type="checkbox"> العربية</label>
                                </div>
                                <div class="check-slide">
                                    <label class="label_check" for="checkbox-04"><input id="checkbox-04" type="checkbox"> الإنجليزية</label>
                                </div>
                            </div>
                            <h3 class="Tajawal-font">أقسام الإختبارات</h3>
                            <div class="filter-blcok">
                                <div class="check-slide">
                                    <label class="label_check" for="checkbox-05">
                                        الإختبارات التعليمية
                                    </label>
                                    <input id="checkbox-05" type="checkbox">
                                </div>
                                <div class="check-slide">
                                    <label class="label_check" for="checkbox-06">
                                        الإختبارات التعليمية
                                    </label>
                                    <input id="checkbox-06" type="checkbox">
                                </div>
                                <div class="check-slide">
                                    <label class="label_check" for="checkbox-07">
                                        الإختبارات التعليمية
                                    </label>
                                    <input id="checkbox-07" type="checkbox">
                                </div>
                                <div class="check-slide">
                                    <label class="label_check" for="checkbox-08">
                                        الإختبارات التعليمية
                                    </label>
                                    <input id="checkbox-08" type="checkbox">
                                </div>
                            </div>
                            <h3 class="Tajawal-font">متوسط السعر</h3>
                            <div class="filter-blcok">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="السعر من">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="السعر إلى">
                                </div>
                                <button type="button" class="btn" name="button">بحث</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="filter-row">
                            <div class="search">
                                <input type="text" placeholder="Search">
                                <input type="submit" value="">
                            </div>
                        </div>
                        @foreach($exams as $exam)
                            <div class="test-page">
                                <div class="event-box">
                                    @if($exam->is_paid() && Auth::user()->payments->contains('exam_id', '=', $exam->id))
                                        <div class="price">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <span class="Tajawal-font">تم الشراء</span>
                                        </div>
                                    @endif
                                    <div class="event-name"><a href="{{ route('exams.show', $exam) }}">{{ $exam->title }}</a></div>
                                    <div class="event-info"><i class="fa fa-clock-o"></i> {{ $exam->exam_duration }} دقيقة</div>
                                    <div class="event-info"><i class="fa fa-question-circle-o" aria-hidden="true"></i> {{ $exam->questions->count() }} سؤال</div>
                                    <div class="event-info"><i class="fa fa-money" aria-hidden="true"></i> {{ $exam->is_paid() ? 'مدفوع' : 'مجاني' }}</div>
                                    @if($exam->is_paid())
                                        <div class="event-info"><i class="fa fa-money" aria-hidden="true"></i> {{ $exam->exam_price }}</div>
                                        <a href="toplist.html" class="btn toplist-btn">قائمة الأفضل</a>
                                    @endif
                                </div>
                            </div>
                            {{--<div class="test-page">--}}
                            {{--<div class="event-box">--}}
                            {{--<div class="price">--}}
                            {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                            {{--<span class="Tajawal-font">تم الشراء</span>--}}
                            {{--</div>--}}
                            {{--<div class="event-name"><a href="paid-test.html">اسم الاختبار في حالة ا ذا كان الاختبارمدفوع</a></div>--}}
                            {{--<div class="event-info"><i class="fa fa-clock-o"></i> 25 دقيقة</div>--}}
                            {{--<div class="event-info"><i class="fa fa-question-circle-o" aria-hidden="true"></i> 75 سؤال</div>--}}
                            {{--<div class="event-info"><i class="fa fa-money" aria-hidden="true"></i> 22$</div>--}}
                            {{--<a href="toplist.html" class="btn toplist-btn">قائمة الأفضل</a>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        @endforeach
                        {{--<div class="test-page">--}}
                        {{--<div class="event-box">--}}
                        {{--<div class="price">--}}
                        {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                        {{--<span class="Tajawal-font">تم الشراء</span>--}}
                        {{--</div>--}}
                        {{--<div class="event-name"><a href="paid-test.html">اسم الاختبار في حالة ا ذا كان الاختبارمدفوع</a></div>--}}
                        {{--<div class="event-info"><i class="fa fa-clock-o"></i> 25 دقيقة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-question-circle-o" aria-hidden="true"></i> 75 سؤال</div>--}}
                        {{--<div class="event-info"><i class="fa fa-money" aria-hidden="true"></i> 22$جاني</div>--}}
                        {{--<a href="toplist.html" class="btn toplist-btn">قائمة الأفضل</a>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="test-page">--}}
                        {{--<div class="event-box">--}}
                        {{--<div class="price">--}}
                        {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                        {{--<span class="Tajawal-font">تم الشراء</span>--}}
                        {{--</div>--}}
                        {{--<div class="event-name"><a href="paid-test.html">اسم الاختبار في حالة ا ذا كان الاختبارمدفوع</a></div>--}}
                        {{--<div class="event-info"><i class="fa fa-clock-o"></i> 25 دقيقة</div>--}}
                        {{--<div class="event-info"><i class="fa fa-question-circle-o" aria-hidden="true"></i> 75 سؤال</div>--}}
                        {{--<div class="event-info"><i class="fa fa-money" aria-hidden="true"></i> 22$</div>--}}
                        {{--<a href="toplist.html" class="btn toplist-btn">قائمة الأفضل</a>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{ $exams->links() }}
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    لا توجد اختبارات في الوقت الحالي
                </div>
            @endif
        </div>
    </section>
@endsection