@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img">
            <img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt="">
        </div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">الأقسام الرئيسية للإختبارات</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('categories.index') }}">الأقسام الرئيسية للإختبارات</a></li>
            </ul>
        </div>
    </section>
    <section class="courses-view list-view">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="group-tab-view">
                        <div class="forum-details">
                            @if(isset($all_categories) && $all_categories->count())
                                @foreach($all_categories as $category)
                                    @if($category->exam_count() == 0)
                                        @continue
                                    @endif
                                    <div class="details-slide {{ $loop->index % 2 == 0 ? 'even' : '' }}">
                                        <div class="name">
                                            <img src="{{ asset('images/user-img/test.png') }}" alt="">
                                            <div class="Tajawal-font fontsize-18">{{ $category->cat_name }}</div>
                                        </div>
                                        @foreach($category->sub_categories as $cat)
                                            @if($cat->exam_count() == 0)
                                                @continue
                                            @endif
                                            <div class="info">
                                                <div class="block fontsize-18">
                                                    <a href="{{ route('categories.show', $cat->id) }}">
                                                        {{ $cat->cat_name }}
                                                    </a>
                                                </div>
                                                <div class="block">{{ $cat->exam_count() }} إختبار</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @elseif(isset($category))
                                <div class="details-slide">
                                    <div class="name">
                                        <img src="{{ asset('images/user-img/test.png') }}" alt="">
                                        <div class="Tajawal-font fontsize-18">{{ $category->cat_name }}</div>
                                    </div>
                                    @foreach($category->sub_categories as $cat)
                                        @if($cat->exam_count() == 0)
                                            @continue
                                        @endif
                                        <div class="info">
                                            <div class="block fontsize-18">
                                                <a href="{{ route('categories.show', $cat->id) }}">
                                                    {{ $cat->cat_name }}
                                                </a>
                                            </div>
                                            <div class="block">{{ $cat->exams->count() }} إختبار</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @if(isset($all_categories))
                            {{ $all_categories->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
