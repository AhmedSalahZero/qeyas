@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">حسابي</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('user.profile') }}">حسابي</a></li>
            </ul>
        </div>
    </section>
    <div class="container">
        @if(session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <div class="my-accountPage">
        <div class="container">
            <div class="my-account">
                <div class="account-tab">
                    <ul>
                        <li @if(!Request()->query('prev_exams')) class="active" @endif ><a href="javascript:void(0);" id="profile">حسابي</a></li>
                        <li><a href="javascript:void(0);" id="order">طلباتي</a></li>
                        <li><a href="javascript:void(0);" id="changePassword">تغيير كلمة المرور</a></li>
                        <li @if(Request()->query('prev_exams')) class="active" @endif><a href="javascript:void(0);" id="exams-results">نتائج الإختبارات السابقة</a></li>
                    </ul>
                </div>
                <div class="tab-content profile-con @if(!Request()->query('prev_exams')) open @endif ">
                    <div class="personal-edit">
                        <a href="{{ route('user.edit-profile') }}"><i class="fa fa-pencil"></i><span>تعديل حسابي</span></a>
                    </div>
                    <div class="personal-information">
                        <div class="info-slide">
                            <p><span>الإسم :</span>{{ $user->name }}</p>
                        </div>
                        <div class="info-slide">
                            <p><span>رقم الهاتف :</span>{{ $user->phone }}</p>
                        </div>
                        <div class="info-slide">
                            <p><span>المرحلة الدراسية :</span>{{ $user->education_level ?? '' }}</p>
                        </div>
                        <div class="info-slide">
                            <p><span>المدينة :</span>{{ $user->user_city->city_name ?? '' }}</p>
                        </div>
                        <div class="info-slide">
                            <p><span>الجنس :</span>{{ $user->gender ? ($user->gender === 'm' ? 'ذكر' : 'أنثى') : '' }}</p>
                        </div>
                    </div>
                </div>
                <div class="tab-content order-con">
                    <h4 class="Tajawal-font fontsize-18">إختباراتي</h4>
                    @if($user->examRequests->count())
                        <table class="booking-viewTable">
						
							<tr>
								<th>
								الاسم
								</th>
								
								<th>
								تاريخ الطلب
								</th>
								
								
								
								<th>
								السعر 
								</th>
								
								
								<th>
								حاله الدفع
								</th>
								
									
								<th>
								
								</th>
								
								
							</tr>
						
                            @foreach($user->examRequests as $examRequest)
							
							
							
							
                                <tr>
                                    <th class="th-name">{{ $examRequest->exam ? $examRequest->exam->title :'-' }}</th>
                                    {{-- <th></th> --}}
                                    <th>{{ formatDateForView($examRequest->created_at) }}</th>
									{{-- <th>{{ $exam->price . ' ' .getMainCurrency() }}</th> --}}
                                    <th>{{ $examRequest->is_paid() ? $examRequest->getPrice() . ' ' . getMainCurrency() : 'مجاني' }}</th>
                                    <th>{{ $examRequest->is_paid() ? $examRequest->getStatusInAr()  : '-'}}</th>
									@if($examRequest->exam)
                                    <th>
                                        <a class="enter-test" href="{{ route('exams.show', $examRequest->exam->id) }}">دخول</a>
										{{-- @if($examRequest->status =='approved')
                                        <a  class="enter-test" href="{{ route('refund.request', $examRequest->payment_id ) }}">استرجاع الاموال</a>
										@endif --}}
                                    </th>
									@endif 
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <h5>لا يوجد اختبارات</h5>
                    @endif
                    <h4 class="Tajawal-font fontsize-18">كتبي</h4>
                    @if($user->bookRequests->count())
                        <table class="booking-viewTable books">	
							<tr>
								<th>
								الاسم
								</th>
								
								<th>
								تاريخ الطلب
								</th>
								
									<th>
								عدد الكتب
								</th>
								
								<th>
								السعر الاجمالي
								</th>
								
								
								<th>
								حاله الدفع
								</th>
								
									
								<th>
								
								</th>
								
								
							</tr>
                            @foreach($user->bookRequests as $bookRequest)
                                <tr>
                                    <th class="th-name">{{ $bookRequest->book ? $bookRequest->book->book_title:'-' }}</th>
                                    {{-- <th>#9876</th> --}}
                                    <th>{{ formatDateForView($bookRequest->created_at)   }}</th>
                                    <th>{{  $bookRequest->no_books }}</th>
                                    <th>{{  $bookRequest->price . ' ' . getMainCurrency() }}</th>
                                    <th>{{  $bookRequest->is_paid() ? $bookRequest->getPaymentStatusInAr() : '-'  }}</th>
                                    <th>
									@if($bookRequest->book)
                                        <a href="{{ route('books.download', $bookRequest->book->id) }}"><i class="fa fa-download fontsize-18" aria-hidden="true"></i></a>
                                        <a target="_blank" href="{{ route('books.view', $bookRequest->book->id) }}"><i class="fa fa-file-pdf-o fontsize-18" aria-hidden="true"></i></a>
											@if($bookRequest->status =='approved' && auth()->user()->canRefund($bookRequest) )
                                        <a  class="enter-test" style="display:block;margin-top:10px;" href="{{ route('refund.request', $bookRequest->payment_id ) }}">استرجاع الاموال</a>
										@endif
										@endif
                                    </th>
                                </tr>
                            @endforeach
                        </table>
						
						 @else
                        <h5>لا توجد كتب</h5>
						
                    @endif
					
					
					<h4 class="Tajawal-font fontsize-18">دوراتي</h4>
                    @if($user->courseRequests->count())
                        <table class="booking-viewTable books">
						
						<tr>
								<th>
								الاسم
								</th>
								
								<th>
								تاريخ الطلب
								</th>
								
								
								
								<th>
								السعر 
								</th>
								
								
								<th>
								حاله الدفع
								</th>
								
									
								<th>
								
								</th>
								
								
							</tr>
							
                            @foreach($user->courseRequests as $courseRequest)
                                <tr>
                                    <th class="th-name">{{ $courseRequest->course ? $courseRequest->course->getTitle() : '-' }}</th>
                                    {{-- <th>#9876</th> --}}
                                    <th>{{ formatDateForView($courseRequest->created_at) }}</th>
                                    <th>{{ $courseRequest->is_paid() ? $courseRequest->getPrice() . ' ' . getMainCurrency() : 'مجاني'}}</th>
                                    <th>{{  $courseRequest->is_paid() ? $courseRequest->getPaymentStatusInAr() : '-'  }}</th>
									@if($courseRequest->course)
                                     <th>
                                        <a class="enter-test" href="{{ route('courses.show', $courseRequest->course->id) }}">عرض</a>
										@if($courseRequest->status =='approved' && auth()->user()->canRefund($courseRequest))
                                        <a style="display:block;margin-top:10px;"  class="enter-test" href="{{ route('refund.request', $courseRequest->payment_id ) }}">استرجاع الاموال</a>
										@endif
                                    </th>
									@endif 
                                </tr>
                            @endforeach
                        </table>
						
						 @else
                        <h5>لا توجد دورات</h5>
						
                    @endif
                </div>
                <div class="tab-content changePassword-con">
                    <div class="change-password ">
                        <form action="{{ route('user.update_password') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-box">
                                <input type="password" name="current_password" placeholder="كلمة المرور الحالية" value="{{ ! is_null($user->social_id) && ! $user->password_changed ? $user->social_id : '' }}" {{ ! is_null($user->social_id) && ! $user->password_changed ? 'readonly': '' }}>
                            </div>
                            @if(! is_null($user->social_id) && ! $user->password_changed)
                                <div class="alert alert-info">
                                    تم التسجيل بواسطة احدى وسائل التواصل الاجتماعي .. تم وضع كلمة مرور افتراضية لك اذا كنت ترغب بتغييرها فاكتب كلمة المرور الجديدة
                                </div>
                            @endif
                            <div class="input-box">
                                <input type="password" name="password" placeholder="كلمة المرور الجديدة">
                            </div>
                            <div class="input-box">
                                <input type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور الجديدة">
                            </div>
                            <div class="submit-box">
                                <input type="submit" value="حفظ" class="btn">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-content exams-results-con @if(Request()->query('prev_exams')) open @endif">
                    <div class="row">
                        @foreach($user->exam_reports as $report)
						@if($report->exam)
                            <div class="col-md-4">
                                <div class="exam-result">
                                    <div class="card">
                                        <a href="{{ route('exams.report', $report) }}">
                                            <h4 class="Tajawal-font font-weight">{{ $report->exam->title }}</h4>
                                        </a>
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
                            </div>
							@endif
                        @endforeach
                        {{--<div class="col-md-4">--}}
                        {{--<div class="exam-result">--}}
                        {{--<div class="card">--}}
                        {{--<a href="exam-report.html">--}}
                        {{--<h4 class="Tajawal-font font-weight">إختبار القدرات العامة باللغة العربية</h4>--}}
                        {{--</a>--}}
                        {{--<p>--}}
                        {{--<span>أعلى نتيجة :</span>--}}
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
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="exam-result">--}}
                        {{--<div class="card">--}}
                        {{--<a href="exam-report.html">--}}
                        {{--<h4 class="Tajawal-font font-weight">إختبار القدرات العامة باللغة العربية</h4>--}}
                        {{--</a>--}}
                        {{--<p>--}}
                        {{--<span>أعلى نتيجة :</span>--}}
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
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row">--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="exam-result">--}}
                        {{--<div class="card">--}}
                        {{--<a href="exam-report.html">--}}
                        {{--<h4 class="Tajawal-font font-weight">إختبار القدرات العامة باللغة العربية</h4>--}}
                        {{--</a>--}}
                        {{--<p>--}}
                        {{--<span>أعلى نتيجة :</span>--}}
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
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="exam-result">--}}
                        {{--<div class="card">--}}
                        {{--<a href="exam-report.html">--}}
                        {{--<h4 class="Tajawal-font font-weight">إختبار القدرات العامة باللغة العربية</h4>--}}
                        {{--</a>--}}
                        {{--<p>--}}
                        {{--<span>أعلى نتيجة :</span>--}}
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
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="exam-result">--}}
                        {{--<div class="card">--}}
                        {{--<a href="exam-report.html">--}}
                        {{--<h4 class="Tajawal-font font-weight">إختبار القدرات العامة باللغة العربية</h4>--}}
                        {{--</a>--}}
                        {{--<p>--}}
                        {{--<span>أعلى نتيجة :</span>--}}
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
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
	
@endsection
