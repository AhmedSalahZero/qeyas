@extends('layouts.app')

@section('content')
    <!-- <section class="banner">
        <div class="banner-img">
            <img src="{{ asset('images/banner/banner-img11.jpg') }}" alt="">
        </div>
{{--        <div class="banner-text">--}}
    {{--            <div class="container">--}}
    {{--                <div class="learning-btn">--}}
    {{--                    <a href="#" class="btn">شاهد تفاصيل الإعلان</a>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
            </section> -->
    @php($slides = \App\HomeSlide::all())
    <section class="banner">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($slides as $slide)
                    <li data-target="#myCarousel" data-slide-to="{{ $loop->index }}" class="{{ $loop->index == 0 ? 'active' : '' }}"></li>
                @endforeach
                {{--<li data-target="#myCarousel" data-slide-to="1"></li>--}}
                {{--<li data-target="#myCarousel" data-slide-to="2"></li>--}}
            </ol>
            <div class="carousel-inner" style="min-height: 400px;">
                @if($slides->count())
                    @foreach($slides as $slide)
                        <div class="item {{ $loop->index == 0 ? 'active' : '' }}" style="max-height: 400px;">
                            <a href="{{ $slide->link }}" title="{{ $slide->label }}">
                                <img src="{{ Voyager::image($slide->image) }}" alt="">
                            </a>
                        </div>
                    @endforeach
                @endif
                {{--                <div class="item">--}}
                {{--                    <a href="#">--}}
                {{--                        <img src="{{ asset('images/slider/img2.jpg') }}" alt="">--}}
                {{--                    </a>--}}
                {{--                </div>--}}
                {{--                <div class="item">--}}
                {{--                    <a href="#">--}}
                {{--                        <img src="{{ asset('images/slider/img3.jpg') }}" alt="">--}}
                {{--                    </a>--}}
                {{--                </div>--}}
            </div>
        </div>
    </section>
    <section class="start-learning">
        <div class="container">
            <div class="holder">
                <ul id="ticker01">
                    @foreach($news as $new)
                        <li>
                            <a href="{{ route('news.show', $new) }}">
                                {{$new->title}}
                            </a>
                            <span style="display: inline-block;">{{$new->news_date->toDateString()}}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <section class="our-tests">
        <div class="container">
            <div class="row">
                @foreach($categories->take(3) as $category)
                    @if($category->exam_count() == 0)
                        @continue
                    @endif
                    <div class="col-md-4">
                        <div class="forum-details">
                            <div class="details-slide">
                                <div class="name">
                                    <img src="{{ asset('images/user-img/test.png') }}" alt="">
                                    <div class="Tajawal-font fontsize-18">{{ $category->cat_name }}</div>
                                </div>
                                @if($category->is_parent())
                                    @foreach($category->sub_categories->take(3) as $sub)
                                        @if($sub->exam_count() == 0)
                                            @continue
                                        @endif
                                        <div class="info">
                                            <div class="block fontsize-18">
                                                <a href="{{ route('categories.show', $sub) }}" title="{{$sub->cat_name}}">
                                                    {{ str_limit($sub->cat_name,27) }}
                                                </a>
                                            </div>
                                            <div class="block">{{ $sub->exam_count() }} إختبار</div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="btn-block">
                                    <a href="{{ route('categories.show', $category) }}" class="btn">المزيد</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="our-course">
        <div class="container">
            <div class="section-title">
                <h2 class="Tajawal-font">أحدث الدورات التدريبية</h2>
            </div>
            <div class="row">
                @foreach($courses as $course)
                    <div class="col-md-4 col-sm-6">
                        <div class="course-box">
                            <div class="img">
                                <img height="350px" src="{{ Voyager::image($course->course_photo, asset('images/courses/courses-img1.jpg')) }}" alt="">
                                <div class="course-info">
                                    <div class="date"><i class="fa fa-calendar"></i>{{ $course->start }}</div>
                                    <div class="date"><i class="fa fa-clock-o"></i>{{ $course->hours }} ساعة</div>
                                </div>
                                <div class="price"> {{ $course->course_price . ' ' . getMainCurrency() }}</div>
                            </div>
                            <div class="course-name" title="{{$course->course_title}}">{{ str_limit($course->course_title,35) }}</div>
                            <div class="comment-row">
                                <div class="box">

                                    @foreach($course->trainers as $trainer)
                                        <i class="fa fa-user-secret" title="المدربين"></i>
                                        {{ $trainer->trainer_name }}
                                        <br/>
                                    @endforeach
                                </div>
                                <div class="enroll-btn">
                                    <a href="{{ route('courses.show', $course) }}" class="btn">إشتراك</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--<div class="col-md-4 col-sm-6">--}}
                {{--<div class="course-box">--}}
                {{--<div class="img">--}}
                {{--<img src="{{ asset('images/courses/courses-img1.jpg') }}" alt="">--}}
                {{--<div class="course-info">--}}
                {{--<div class="date"><i class="fa fa-calendar"></i>22 مايو 2019</div>--}}
                {{--<div class="date"><i class="fa fa-clock-o"></i>22 ساعة</div>--}}
                {{--</div>--}}
                {{--<div class="price">$100</div>--}}
                {{--</div>--}}
                {{--<div class="course-name">مفاهيم تعليمية</div>--}}
                {{--<div class="comment-row">--}}
                {{--<div class="box"><i class="fa fa-user-secret"></i>أ/ محمد السيد</div>--}}
                {{--<div class="enroll-btn">--}}
                {{--<a href="#" class="btn">إشتراك</a>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-4 col-sm-6">--}}
                {{--<div class="course-box">--}}
                {{--<div class="img">--}}
                {{--<img src="{{ asset('images/courses/courses-img1.jpg') }}" alt="">--}}
                {{--<div class="course-info">--}}
                {{--<div class="date"><i class="fa fa-calendar"></i>22 مايو 2019</div>--}}
                {{--<div class="date"><i class="fa fa-clock-o"></i>22 ساعة</div>--}}
                {{--</div>--}}
                {{--<div class="price">$100</div>--}}
                {{--</div>--}}
                {{--<div class="course-name">مفاهيم تعليمية</div>--}}
                {{--<div class="comment-row">--}}
                {{--<div class="box"><i class="fa fa-user-secret"></i>أ/ محمد السيد</div>--}}
                {{--<div class="enroll-btn">--}}
                {{--<a href="#" class="btn">إشتراك</a>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </section>
    <section class="our-team Toplist">
        <div class="section-title">
            <h2 class="Tajawal-font">قائمة المتميزين</h2>
        </div>
        @php($toplist = App\ExamReport::orderBy('highest_result', 'desc')->take(6)->get())
        <div class="member-slider">
            @foreach($toplist as $t)
                <div class="event-box">
                    <div class="price">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <span>{{ $loop->index + 1 }}</span>
                    </div>
                    <div class="img text-center">
                        <img src="{{ Voyager::image($t->user->avatar, asset('images/event/img1.jpg')) }}" alt="">
                    </div>
                    <div class="event-name"><a href="#">{{ $t->user->name }}</a></div>
                    <div class="event-info"><i class="fa fa-clock-o"></i> {{ $t->time_spent }} دقيقة</div>
                    <div class="event-info"><i class="fa fa-map-marker"></i>{{ $t->user->city }}</div>
                    <div class="event-info"><i class="fa fa-percent"></i>{{ $t->percentage }}</div>
                </div>
            @endforeach
        </div>
    </section>
    <section class="our-course our-books">
        <div class="container">
            <div class="section-title">
                <h2 class="Tajawal-font">أحدث الكتب المضافة</h2>
            </div>
            <div class="row">
                @foreach($books as $book)
                    <div class="col-md-4 col-sm-6">
                        <div class="course-box">
                            @auth
                                <a href="{{ route('books.view', $book) }}">
                                    @endauth
                                    <div class="img">
                                        <img src="{{ Voyager::image($book->book_photo, asset('images/courses/courses-img1.jpg')) }}" height="368px" alt="">
                                        <div class="course-info">
                                            <div class="date"><i class="fa fa-calendar"></i>{{ $book->release_date }}</div>
                                        </div>
                                    </div>
                                    @auth
                                </a>
                            @endauth
                            <div class="course-name Tajawal-font" title="{{$book->book_title}}">{{ str_limit($book->book_title,30) }}
                                <span class="Tajawal-font" title="{{$book->book_description}}">
                                    {{ str_limit($book->book_description, 50) }}
                                </span>
                            </div>
                            <div class="comment-row">
                                <div class="box"></div>
                                <div class="enroll-btns">
                                    @auth
                                        <a href="{{ route('books.view', $book) }}" class="btn">تصفح الكتاب</a>
                                        <a href="{{ route('books.download', $book) }}" class="btn3">
                                            <i class="fa fa-download" aria-hidden="true"></i> تحميل الكتاب
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--<div class="col-md-4 col-sm-6">--}}
                {{--<div class="course-box">--}}
                {{--<div class="img">--}}
                {{--<img src="{{ asset('images/courses/courses-img1.jpg') }}" alt="">--}}
                {{--<div class="course-info">--}}
                {{--<div class="date"><i class="fa fa-calendar"></i>22 مايو 2019</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="course-name Tajawal-font">اسم الكتاب--}}
                {{--<span class="Tajawal-font">--}}
                {{--هذا النص هو مثال لنص يمكن أن يستبدل في نفس--}}
                {{--المساحة، لقد تم توليد هذا النص من مولد النص العربى--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<div class="comment-row">--}}
                {{--<div class="box"></div>--}}
                {{--<div class="enroll-btns">--}}
                {{--<a href="preview-book.html" class="btn">تصفح الكتاب</a>--}}
                {{--<a href="preview-book.html" class="btn3"><i class="fa fa-download" aria-hidden="true"></i> تحميل الكتاب</a>--}}
                {{--</div>--}}
                {{--<div class="div-box">dwdwdw</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-4 col-sm-6">--}}
                {{--<div class="course-box">--}}
                {{--<div class="img">--}}
                {{--<img src="{{ asset('images/courses/courses-img1.jpg') }}" alt="">--}}
                {{--<div class="course-info">--}}
                {{--<div class="date"><i class="fa fa-calendar"></i>22 مايو 2019</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="course-name Tajawal-font">اسم الكتاب--}}
                {{--<span class="Tajawal-font">--}}
                {{--هذا النص هو مثال لنص يمكن أن يستبدل في نفس--}}
                {{--المساحة، لقد تم توليد هذا النص من مولد النص العربى--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<div class="comment-row">--}}
                {{--<div class="box"></div>--}}
                {{--<div class="enroll-btns">--}}
                {{--<a href="preview-book.html" class="btn">تصفح الكتاب</a>--}}
                {{--<a href="preview-book.html" class="btn3"><i class="fa fa-download" aria-hidden="true"></i> تحميل الكتاب</a>--}}
                {{--</div>--}}
                {{--<div class="div-box">dwdwdw</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </section>
    <section class="start-learning">
        <div class="container">
            <div class="holder text-center">
                <p><img src="{{ asset('images/test.svg') }}" alt=""> {{ \App\Exam::count() }} إختبار</p>
                <p><img src="{{ asset('images/course.svg') }}" alt=""> {{ \App\Course::count() }} دورة تدريبية</p>
                <p><img src="{{ asset('images/book.svg') }}" alt=""> {{ \App\Book::count() }} كتاب إلكتروني</p>
                <p><img src="{{ asset('images/user.svg') }}" alt=""> {{ \App\User::where('role_id', 2)->count() }} مستخدم</p>
            </div>
        </div>
    </section>
    <section class="contact-block">
        <div class="contact-form">
            <div class="section-title">
                <h2 class="Tajawal-font">تواصل معنا</h2>
            </div>
            <div class="form-filde">
                <form action="thank-you.html" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-box">
                                <input type="text" placeholder="الإسم" data-validation="required" name="name">
                            </div>
                            <div class="input-box">
                                <input type="text" placeholder="رقم الهاتف" data-validation="required" name="phone">
                            </div>
                            <div class="input-box">
                                <select class="form-control" data-validation="required" name="subject">
                                    <option value="">سبب الإتصال</option>
                                    <option value="complaint">شكوى</option>
                                    <option value="suggestion">اقتراح</option>
                                    <option value="other">اخرى</option>
                                </select>
                            </div>
                            <div class="input-box">
                                <textarea placeholder="محتوى الرسالة" data-validation="required" name="message"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="submit-box">
                                <input type="submit" value="إرسال" class="btn">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="map" id="map">
        </div>
    </section>
    <section>
        <button class="open-button" onclick="openForm()"><i class="fa fa-commenting fontsize-30" aria-hidden="true"></i></button>

        <div class="chat-popup" id="myForm">
            <form action="" class="form-container">
                <div class="msg-header">
                    <h4>أهلا و سهلا بك في قياس2030</h4>
                    <p>نحن نرد على كل رسالة لذا لا تتردد في السؤال عن اي شئ</p>
                </div>
                <textarea placeholder="أكتب رسالتك هنا..." name="msg" required></textarea>
                <div class="msg-footer">
                    <button type="submit" class="btn">إرسال</button>
                    <button type="button" class="btn cancel" onclick="closeForm()">إغلاق</button>
                </div>
            </form>
        </div>
    </section>
@endsection
