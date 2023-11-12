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
                <li><a href="{{ route('exams.index') }}">إختبارات قياس</a></li>
                <li>البحث</li>
            </ul>
        </div>
    </section>
    <section class="courses-view list-view">
        <div class="container">

            <div class="row">
                <div class="col-md-3 hidden-sm hidden-xs">
                    <div class="right-slide left">
                        <form action="{{ route('exams.search') }}">
                            <h3 class="Tajawal-font">نوع الإختبار</h3>
                            <div class="filter-blcok">
                                <div class="check-slide">
                                    <label class="label_check" for="exam_type_free">
                                        <input id="exam_type_free" name="free_exam" type="checkbox" value="1" {{ request('free_exam') == 1 ? 'checked' : '' }}> مجاني
                                    </label>
                                </div>
                                <div class="check-slide">
                                    <label class="label_check" for="exam_type_paid">
                                        <input id="exam_type_paid" name="paid_exam" type="checkbox" value="1" {{ request('paid_exam') == 1 ? 'checked' : '' }}> مدفوع
                                    </label>
                                </div>
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
                            <h3 class="Tajawal-font">أقسام الإختبارات</h3>
                            <div class="filter-blcok">
                                @foreach($categories as $cat)
                                    <div class="check-slide">
                                        <label class="label_check" for="checkbox-{{ $loop->index }}">
                                            <input id="checkbox-{{ $loop->index }}" name="categories[]"
                                                   {{ (in_array($cat->id, request('categories') ?? []) ? 'checked' : '') }}
                                                   type="checkbox" value="{{ $cat->id }}">
                                            {{ $cat->cat_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <h3 class="Tajawal-font">متوسط السعر</h3>
                            <div class="filter-blcok">
                                <div class="form-group">
                                    <input type="number" min=0 name="from_price" class="form-control" placeholder="السعر من" value="{{ request('from_price') ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <input type="number" min=0 name="to_price" class="form-control" placeholder="السعر إلى" value="{{ request('to_price') ?? '' }}">
                                </div>
                                <button type="submit" class="btn" name="button">بحث</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="filter-row">
                        <form action="{{ route('exams.search') }}" method="get">
                            <div class="search">
                                <input type="text" name="q" placeholder="Search">
                                <input type="submit" value="">
                            </div>
                        </form>
                    </div>
                    @if($exams->count())
                        @foreach($exams as $exam)
                            <div class="test-page">
                                <div class="event-box">
                                    @if(Auth::check() && ! Auth::user()->is_admin())
                                        @if($exam->is_paid() && Auth::user()->has_exam($exam->id))
                                            <div class="price">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <span class="Tajawal-font">تم الشراء</span>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="event-name">
                                        <a href="{{ route('exams.show', $exam) }}">
                                            {{ $exam->title }}
                                        </a>
                                    </div>
                                    <div class="event-info">
                                        <i class="fa fa-clock-o"></i>
                                        {{ $exam->exam_duration }}دقيقة
                                    </div>
                                    <div class="event-info">
                                        <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                                        {{ $exam->questions->count() }}سؤال / أسئلة
                                    </div>
                                    <div class="event-info">
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                        {{ $exam->is_paid() ? 'مدفوع' : 'مجاني' }}
                                    </div>
                                    @if($exam->is_paid())
                                        <div class="event-info">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            {{ $exam->exam_price }}
                                        </div>
                                    @endif
                                    <a href="{{ route('exams.toplist', $exam) }}" class="btn toplist-btn">
                                        قائمة الأفضل
                                    </a>
                                </div>
                            </div>
                        @endforeach
                </div>
                {{ $exams->links() }}
            </div>
            @else
                <div class="alert alert-info">
                    لا توجد نتائج لهذا البحث
                </div>
            @endif
        </div>
    </section>
@endsection