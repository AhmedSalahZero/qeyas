@extends('layouts.app')

@section('content')
<section class="banner inner-page">
    <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
    <div class="page-title">
        <div class="container">
            <h1 class="Tajawal-font">
                تفاصيل الدورة
                <br>

                {{ $course->getName() }}

            </h1>


        </div>
    </div>
</section>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{ route('home') }}">الرئيسية</a></li>
            <li><a href="{{ route('courses.index') }}">الدورات التدريبية</a></li>
            <li><a href="{{ route('courses.show',$course->getType()) }}">{{ $course->getType() }}</a></li>
            <li><a href="{{ route('courses.show', $course) }}">تفاصيل الدورة</a></li>
        </ul>
    </div>
</section>
<div class="container">
    @if(session('message'))
    <div class="alert alert-info">{{ session('message') }}</div>
    @endif
</div>
<div class="course-details">
    <div class="container">
        <h2 class="Tajawal-font">{{ $course->course_title }}</h2>
        <div class="course-details-main">
            <div class="course-img">
                <img src="{{ Voyager::image($course->course_photo) }}" alt="">
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="course-instructorInfo">
                        <div class="info-slide">
                            <div class="date"><i class="fa fa-clock-o"></i>{{ $course->hours }} ساعة</div>
                        </div>
                        <div class="info-slide"><i class="fa fa-calendar"></i>{{ $course->start }} - {{ $course->end }}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="btn-row">
                        <div class="price"><span>السعر : </span>{{ $course->course_price == 0 ? 'مجاني' : $course->course_price }} {{ getMainCurrency() }} </div>
                    </div>
                </div>
            </div>

        </div>

        @if($debrief = $course->getDebrief())
        <div class="info">
            <h4>نبذه عن الدورة</h4>
            {!! $debrief !!}
        </div>
        @endif
		
		@if($intro=$course->getIntro())
		@if($videoId = \App\Course::getVideoId($intro))		
		 <div class="blog-slide">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $videoId  }}" allowfullscreen></iframe>
                            </div>
                            {{-- <div class="info">
                                <div class="name">{{ $video->video_title }}</div>
                                <div class="post-info">
                                    <span><i class="fa fa-eye" aria-hidden="true"></i>{{ $video->video_num_watches }} مشاهدة</span>
                                    <span><i class="fa fa-calendar" aria-hidden="true"></i>{{ $video->date }}</span>
                                </div>
                                <p>{{ str_limit($video->video_description, 200) }}</p>
                            </div> --}}
                        </div>
						@endif 
		
		@endif 
		

        @if($goals = $course->getGoals())
        <div class="info">
            <h4>اهداف الدورة</h4>
            {!! $goals !!}
        </div>
        @endif


        @if($mainLines = $course->getMainLines())
        <div class="info">
            <h4>العناصر الرئيسية</h4>
            {!! $mainLines !!}
        </div>
        @endif





        <div class="info">
            <h4>تفاصيل الدورة</h4>
            <p>
                {{ $course->course_description }}
            </p>
        </div>
		
	
		  <div class="info">
            <h4>
				@if($course->isLive())
			موعد البدايه
			@else 
تاريخ التسجيل				
			@endif 

			</h4>
            <p>
                {{ $course->start_date }}
            </p>
        </div>
				@if($course->isLive())
		  <div class="info">
            <h4>موعد النهايه</h4>
            <p>
                {{ $course->end_date }}
            </p>
        </div>
		
		
		
		@endif 
		
        <div class="instructors">
            <h4>المدربين</h4>
            <div class="row">
                @foreach($course->trainers as $trainer)
                <div class="col-sm-4">
                    <div class="instructors-box">
                        <div class="img">
                            <img src="{{ Voyager::image($trainer->image) }}" alt="" height="370px">
                        </div>
                        <div class="name">{{ $trainer->trainer_name }}</div>
                        {{--<div class="name">الرياضيات</div>--}}
                    </div>
                </div>
                @endforeach

            </div>
        </div>

       @if(count($course->videos) && auth()->user()->has_course($course->id))
	
            <h4>الفيديوهات</h4>
	    <div class="row">
		
                    @foreach($course->videos as $video)
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
                                {{-- <a href="{{ route('videos.show', $video) }}" class="btn fontsize-14">مشاهدة التفاصيل</a> --}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{-- {{ $videos->links() }} --}}

            </div>
			@endif
			
			
			
			
        <div class="course-form">
            @auth('web')
			@if(!auth()->user()->has_course($course->id))
            <button type="button" class="btn btn-lg" data-toggle="modal" data-target="#myModal">سجل الآن</button>
			@endif
            @else
            <a href="{{ route('login') }}" class="btn btn-lg">تسجيل الدخول لطلب الدورة</a>
            @endauth
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title Tajawal-font">عنوان الدورة</h3>
                    </div>
                    <form action="{{ route('courses.request', $course) }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">الإسم</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="الإسم" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">رقم الهاتف</label>
                                <input type="number" name="phone" class="form-control" id="phone" placeholder="رقم الهاتف" required>
                            </div>
                            <div class="form-group">
                                <label for="message">الرسالة</label>
                                <textarea class="form-control" name="message" id="message" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn">
							@if($course->isFree())
							إرسال طلب حجز
							@else
							الذهاب لصفحه الدفع
							@endif 
							
							</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
