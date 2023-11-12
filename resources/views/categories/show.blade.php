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
                <li>{{ $category->cat_name }}</li>
            </ul>
        </div>
    </section>
    <section class="courses-view list-view">
        <div class="container">
            @if($category->exam_count())
                <div class="row">
                    <div class="col-md-3 hidden-sm hidden-xs">
                        <div class="right-slide left">
                            <form action="{{ route('exams.search') }}" method="get">
                                <h3 class="Tajawal-font">نوع الإختبار</h3>
                                <div class="filter-blcok">
                                    <div class="check-slide">
                                        <label class="label_check" for="exam_type_free">
                                            <input  id="exam_type_free" type="checkbox" name="free_exam" value="1"> مجاني
                                        </label>
                                    </div>
                                    <div class="check-slide">
                                        <label class="label_check" for="exam_type_paid">
                                            <input id="exam_type_paid" type="checkbox" name="paid_exam" value="1"> مدفوع
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
								{{-- {{ }} --}}
                                <h3 class="Tajawal-font">أقسام الإختبارات</h3>
                                <div class="filter-blcok">
								{{-- {{ dd($category->parent_category) }} --}}
                                    @foreach($categories as $index=>$cat)
	{{-- {{ dd() }} --}}
	{{-- {{ logger($cat->cat_parent) }} --}}
									{{-- {{ dump($cat->cat_parent , $category->id) }} --}}
                                        <div class="check-slide">
                                            <label class="label_check" for="checkbox-{{ $loop->index }}">
                                                <input @if(activeCategory($category,$cat))  checked @endif id="checkbox-{{ $loop->index }}" type="checkbox"
                                                       name="categories[]"
                                                       value="{{ $cat->id }}">
                                                {{ $cat->cat_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <h3 class="Tajawal-font">متوسط السعر</h3>
                                <div class="filter-blcok">
                                    <div class="form-group">
                                        <input type="number" name="from_price" class="form-control" placeholder="السعر من">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="to_price" class="form-control" placeholder="السعر إلى">
                                    </div>
                                    <button type="submit" class="btn" name="button">بحث</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="filter-row">
                            <div class="search">
                                <form action="{{ route('exams.search') }}" method="get">
                                    <input type="text" name="q" placeholder="Search">
                                    <input type="submit" value="">
                                </form>
                            </div>
                        </div>
                        @foreach($category->getExamsQuery()->paginate(10) as $examIndex=>$exam)
					
						<h2 class="mb-2 text-center " > اختبار رقم  {{ convertIntToArabicString($examIndex+1) }} </h2>
                            <div class="test-page">
                                <div class="event-box" >
                                    @if(Auth::check() )
									{{-- {{ dd(Auth::user()->has_exam($exam->id) , $exam->is_paid()) }} --}}
                                        @if($exam->is_paid() && Auth::user()->has_exam($exam->id))
                                            <div class="price" style="background-color:green">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <span class="Tajawal-font">
												تم الشراء</span>
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
                                        {{ $exam->exam_duration }} دقيقة
                                    </div>
                                    <div class="event-info">
                                        <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                                        {{ $exam->questions->count() }} سؤال / أسئلة
                                    </div>
                                    <div class="event-info">
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                        {{ $exam->is_paid() ? 'مدفوع' : 'مجاني' }}
                                    </div>
                                    @if($exam->is_paid())
                                        <div class="event-info">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            {{ $exam->exam_price }} {{ getMainCurrency() }}
                                        </div>
                                    @endif
									
                                    <a href="{{ route('exams.buy', $exam) }}" class="btn toplist-btn">
                                    {{-- <a href="{{ route('exams.toplist', $exam) }}" class="btn toplist-btn"> --}}
										{{-- @if($exam->is_paid()) --}}
										{{-- {{ dd(auth()->user()->has_exam($exam) ) }} --}}
										@if(auth()->check() && auth()->user()->has_exam($exam->id) || $exam->exam_type =='free')
										بدا الاختبار
										@else
										الاشتراك في الاختبار
										@endif 
										{{-- @else 
										@endif  --}}
									</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $category->exams()->paginate(10)->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    لا توجد اختبارات في هذا التصنيف
                </div>
            @endif
        </div>
    </section>
@endsection
