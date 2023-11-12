@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">مكتبة الفيديو</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('videos.index') }}">مكتبة الفيديو</a></li>
            </ul>
        </div>
    </section>
    <div class="blog-page">
        <div class="container">
            <div class="row">

                    @foreach($videos as $video)
                    <div class="col-md-6">
                        <div class="blog-slide">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $video->video_id }}" allowfullscreen></iframe>
                            </div>
                            <div class="info">
                                <div class="name">{{ $video->video_title }}</div>
                                <div class="post-info">
                                    <span><i class="fa fa-eye" aria-hidden="true"></i>{{ $video->video_num_watches }} مشاهدة</span>
                                    <span><i class="fa fa-calendar" aria-hidden="true"></i>{{ $video->date }}</span>
                                </div>
                                <p>{{ str_limit($video->video_description, 200) }}</p>
                                <a href="{{ route('videos.show', $video) }}" class="btn fontsize-14">مشاهدة التفاصيل</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{ $videos->links() }}

            </div>
        </div>
    </div>
@endsection
