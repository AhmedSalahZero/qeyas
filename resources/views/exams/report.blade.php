@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">تقرير عن الإختبار</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('user.profile') }}">حسابي</a></li>
                <li>{{ $report->exam->title }}</li>
            </ul>
        </div>
    </section>
    <div class="exam-report">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <p>
                        <span>أعلى نتيجة :</span>
                        <span>{{ $report->highest_result }}</span>
                    </p>
                    <p>
                        <span>عدد مرات الدخول :</span>
                        <span>{{ $report->num_tries }} مرات</span>
                    </p>
                    <p>
                        <span>الوقت المنقضي :</span>
                        <span>{{ $report->time_spent }}</span>
                    </p>
                    <p>
                        <span>تاريخ آخر دخول للإمتحان :</span>
                        <span>{{ $report->last_try }}</span>
                    </p>
                </div>
            </div>
            <div class="row">
                <h4 class="Tajawal-font font-weight">المحاولات السابقة</h4>
                @foreach($tries as $try)
                    <div class="col-md-4">
                        <div class="exam-result">
                            <div class="card">
                                <p>
                                    <span>النتيجة :</span>
                                    <span>{{ $try->percentage . '%' }}</span>
                                </p>
                                <p>
                                    <span>الوقت المنقضي :</span>
                                    <span>{{ $try->time_spent }}</span>
                                </p>
                                <div class="wrong-answers text-center">
                                    <a href="#" data-toggle="modal" data-target="#ans-Modal{{ $loop->index }}"><i class="fa fa-times" aria-hidden="true"></i> {{ $try->failed_questions->count() }} أسئلة خاطئة</a>
                                </div>

                                <!--modal-->
                                <div id="ans-Modal{{ $loop->index }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">الأسئلة الخاطئة وإجابتها الصحيحة</h4>
                                            </div>
                                            <div class="modal-body">
                                                @foreach($try->failed_questions as $question)
                                                    <div class="correct-ans">
                                                        <div class="qustion fontsize-16">
                                                            @if(isset($question->question->question_text))
                                                                {!! $question->question->question_text !!}
                                                            @endif
                                                            @if(isset($question->question->question_img))
                                                                <img class="q-img"
                                                                     src="{{ Voyager::image($question->question->question_img) }}"
                                                                     alt="">
                                                            @endif
                                                        </div>
                                                        <div class="wrong-ans">
                                                            <span class="Tajawal-font fontsize-18 red-text">الإجابة الخاطئة : </span>
                                                            <span class="Tajawal-font fontsize-16">
                                                                @if(isset($question->answer->option_text))
																{!! $question->answer->option_text !!}
                                                                @endif
                                                            </span>
                                                            @if(isset($question->answer->option_img))
                                                                <img class="ans-img" src="{{ Voyager::image($question->answer->option_img) }}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="right-ans">
                                                            <span class="Tajawal-font fontsize-18 green-text">الإجابة الصحيحة : </span>
                                                            <span class="Tajawal-font fontsize-16">
                                                                @if(isset($question->right_answer->option_text))
																{!! $question->right_answer->option_text !!}
                                                                @endif
                                                            </span>
                                                            @if(isset($question->right_answer->option_img))
                                                                <img class="ans-img" src="{{ Voyager::image($question->right_answer->option_img) }}" alt="">
                                                            @endif
															{{-- {{ dd($question->question) }} --}}
															{{-- {{ dd($question->question->explanation) }} --}}
                                                            @if(isset($question->question->explanation))
                                                                <span style="display: block;" class="Tajawal-font fontsize-18 text-primary">التعليل :</span>
                                                                <span class="Tajawal-font">{!! $question->question->explanation !!}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                                {{--<div class="correct-ans">--}}
                                                {{--<div class="qustion fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</div>--}}
                                                {{--<div class="wrong-ans">--}}
                                                {{--<span class="Tajawal-font fontsize-18 red-text">الإجابة الخاطئة : </span>--}}
                                                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                                                {{--</div>--}}
                                                {{--<div class="right-ans">--}}
                                                {{--<span class="Tajawal-font fontsize-18 green-text">الإجابة الصحيحة : </span>--}}
                                                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="correct-ans">--}}
                                                {{--<div class="qustion fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟ <img class="q-img" src="images/blog/img1.jpg" alt=""></div>--}}
                                                {{--<div class="wrong-ans">--}}
                                                {{--<span class="Tajawal-font fontsize-18 red-text">الإجابة الخاطئة : </span>--}}
                                                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                                                {{--<img class="ans-img" src="images/blog/img1.jpg" alt="">--}}
                                                {{--</div>--}}
                                                {{--<div class="right-ans">--}}
                                                {{--<span class="Tajawal-font fontsize-18 green-text">الإجابة الصحيحة : </span>--}}
                                                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                                                {{--<img class="ans-img" src="images/blog/img1.jpg" alt="">--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="right-answers text-center">
                                    <a href="#"><i class="fa fa-check" aria-hidden="true"></i> {{ $try->num_passed_questions }} أسئلة صحيحة</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--<div class="col-md-4">--}}
                {{--<div class="exam-result">--}}
                {{--<div class="card">--}}
                {{--<p>--}}
                {{--<span>النتيجة :</span>--}}
                {{--<span>40 نقطة</span>--}}
                {{--</p>--}}
                {{--<p>--}}
                {{--<span>عدد مرات الدخول :</span>--}}
                {{--<span>3 مرات</span>--}}
                {{--</p>--}}
                {{--<p>--}}
                {{--<span>الوقت المنقضي :</span>--}}
                {{--<span>00 : 12 : 23</span>--}}
                {{--</p>--}}
                {{--<p>--}}
                {{--<span>تاريخ آخر دخول للإمتحان :</span>--}}
                {{--<span>22 مايو 2019</span>--}}
                {{--</p>--}}
                {{--<div class="wrong-answers text-center">--}}
                {{--<a href="#" data-toggle="modal" data-target="#ans-Modal"><i class="fa fa-times" aria-hidden="true"></i> 4 أسئلة خاطئة</a>--}}
                {{--</div>--}}

                {{--<!--modal-->--}}
                {{--<div id="ans-Modal" class="modal fade" role="dialog">--}}
                {{--<div class="modal-dialog">--}}
                {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">الأسئلة الخاطئة وإجابتها الصحيحة</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                {{--<div class="correct-ans">--}}
                {{--<div class="qustion fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟ <img class="q-img" src="images/blog/img1.jpg" alt=""></div>--}}
                {{--<div class="wrong-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 red-text">الإجابة الخاطئة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--<img class="ans-img" src="images/blog/img1.jpg" alt="">--}}
                {{--</div>--}}
                {{--<div class="right-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 green-text">الإجابة الصحيحة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--<img class="ans-img" src="images/blog/img1.jpg" alt="">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="correct-ans">--}}
                {{--<div class="qustion fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</div>--}}
                {{--<div class="wrong-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 red-text">الإجابة الخاطئة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--</div>--}}
                {{--<div class="right-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 green-text">الإجابة الصحيحة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="correct-ans">--}}
                {{--<div class="qustion fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟ <img class="q-img" src="images/blog/img1.jpg" alt=""></div>--}}
                {{--<div class="wrong-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 red-text">الإجابة الخاطئة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--<img class="ans-img" src="images/blog/img1.jpg" alt="">--}}
                {{--</div>--}}
                {{--<div class="right-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 green-text">الإجابة الصحيحة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--<img class="ans-img" src="images/blog/img1.jpg" alt="">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="right-answers text-center">--}}
                {{--<a href="#"><i class="fa fa-check" aria-hidden="true"></i> 22 أسئلة صحيحة</a>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-4">--}}
                {{--<div class="exam-result">--}}
                {{--<div class="card">--}}
                {{--<p>--}}
                {{--<span>النتيجة :</span>--}}
                {{--<span>40 نقطة</span>--}}
                {{--</p>--}}
                {{--<p>--}}
                {{--<span>عدد مرات الدخول :</span>--}}
                {{--<span>3 مرات</span>--}}
                {{--</p>--}}
                {{--<p>--}}
                {{--<span>الوقت المنقضي :</span>--}}
                {{--<span>00 : 12 : 23</span>--}}
                {{--</p>--}}
                {{--<p>--}}
                {{--<span>تاريخ آخر دخول للإمتحان :</span>--}}
                {{--<span>22 مايو 2019</span>--}}
                {{--</p>--}}
                {{--<div class="wrong-answers text-center">--}}
                {{--<a href="#" data-toggle="modal" data-target="#ans-Modal"><i class="fa fa-times" aria-hidden="true"></i> 4 أسئلة خاطئة</a>--}}
                {{--</div>--}}

                {{--<!--modal-->--}}
                {{--<div id="ans-Modal" class="modal fade" role="dialog">--}}
                {{--<div class="modal-dialog">--}}
                {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">الأسئلة الخاطئة وإجابتها الصحيحة</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                {{--<div class="correct-ans">--}}
                {{--<div class="qustion fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟ <img class="q-img" src="images/blog/img1.jpg" alt=""></div>--}}
                {{--<div class="wrong-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 red-text">الإجابة الخاطئة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--<img class="ans-img" src="images/blog/img1.jpg" alt="">--}}
                {{--</div>--}}
                {{--<div class="right-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 green-text">الإجابة الصحيحة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--<img class="ans-img" src="images/blog/img1.jpg" alt="">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="correct-ans">--}}
                {{--<div class="qustion fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</div>--}}
                {{--<div class="wrong-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 red-text">الإجابة الخاطئة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--</div>--}}
                {{--<div class="right-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 green-text">الإجابة الصحيحة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="correct-ans">--}}
                {{--<div class="qustion fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟ <img class="q-img" src="images/blog/img1.jpg" alt=""></div>--}}
                {{--<div class="wrong-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 red-text">الإجابة الخاطئة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--<img class="ans-img" src="images/blog/img1.jpg" alt="">--}}
                {{--</div>--}}
                {{--<div class="right-ans">--}}
                {{--<span class="Tajawal-font fontsize-18 green-text">الإجابة الصحيحة : </span>--}}
                {{--<span class="Tajawal-font fontsize-16">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة</span>--}}
                {{--<img class="ans-img" src="images/blog/img1.jpg" alt="">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="right-answers text-center">--}}
                {{--<a href="#"><i class="fa fa-check" aria-hidden="true"></i> 22 أسئلة صحيحة</a>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection
