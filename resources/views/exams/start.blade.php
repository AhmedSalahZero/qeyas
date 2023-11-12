@extends('layouts.app')

@section('content')
<style>
.ans-slide .label_radio img{
	max-width:initial;
}
p{
	margin-bottom:0;
}
.question-parent, .question-parent * sup {
    top:-12px !important;
    }
</style>
@if($exam->isEnglish())
<style>
	.quiz-view .qustion-box .ans .ans-slide .label_radio {
		background-position-x:left;
		padding-left:25px;
	 }
	 .quiz-view .qustion-box .ans .ans-slide .label_radio.r_on{
		background-position-x:left;
		
	 }
     

</style>
@endif 
<style>
table span {
	padding-top:35px;
}
.question-text-style{
	display:inline-flex !important;
	align-items:start;
	gap:10px;
}
.question-parent *:not(table):not(td):not(tr):not(tbody):not(thead) {
	
}
.question-parent,
.question-parent *
{
	font-size:26px !important;
	text-align:right;
}
@media(max-width:767px){
.question-parent,
.question-parent *
{
	font-size:18px !important;
	text-align:right;
}	
}

.label_radio,
.label_radio *
 {
	font-size:20px !important;
}
    .btn-rotate {
        display: inline-flex;
        jusify-content: center;
        align-items: center;
    }
	.swal2-confirm{
		background-color:#FE5E00 !important;
		
	}
.swal-wide{
    min-width:50% !important;
}

    .qustion.paragraph p {
        display: inline-block;
        margin-left: 15px;
    }

    .rotate--90 {
        transform: rotate(-90deg)
    }

    .rotate-90 {
        transform: rotate(90deg)
    }

    .transition-element {
        transition: all 0.3s;
    }

</style>

@if($exam->lang =='en')
<style>

.question-parent,
.question-parent *
{
	text-align:left !important;
}
</style>
@endif 
<div data-value="0" id="show-exam-close-to-end"></div>
<section class="banner inner-page">
    <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
    <div class="page-title">
        <div class="container">
            <h1 class="Tajawal-font">{{ $exam->title }}</h1>
        </div>
    </div>
</section>
<section class="breadcrumb" id="scroll-to">
    <div class="container">
		<div>
		<h1>Loool1</h1>
		<h١>Loool2</h١>
		</div>
        <ul>
            <li><a href="{{ route('categories.show', $exam->category) }}">القسم الفرعي</a></li>
            <li><a href="{{ route('exams.show', $exam) }}">تعليمات قبل الاختبار</a></li>
            <li>{{ $exam->title }}</li>
        </ul>
    </div>
</section>
<section class="quiz-view">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <div id="countdown" style="direction: ltr"></div>
                <div class="qustion-list">
                    @foreach($sections as $section)
                    @if($section->questions->count())
                    <div class="qustion-slide" id="section-{{ $loop->index + 1 }}-title">
                        <div class="qustion-number">{{ $section->section_title }}</div>
                        <span>{{ $section->questions->count() }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            <!-- has class exam_en or exam_ar based on exam language -->
            <div class="col-sm-8 col-md-9 exam_{{ $exam->lang }}">
                @if(count($errors->all()))
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('exams.post_exam') }}" method="post" id="exam-from">
                    {{ csrf_field() }}
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <input type="hidden" name="userSubmit" id="user_submit" value=0>
                    <input type="hidden" name="time_spent" id="time_spent">
                    <div class="qustion-main" id="questions">
                        <div class="qustion-box" id="question-box">
                            @foreach($sections as $section)
                            @if($section->questions->count())
                            <div class="sections" id="section-{{ $loop->index + 1 }}">
                                <div class="dept-title fontsize-18" style="margin-bottom: 10px;">
                                    <b>{{ $section->section_title }}</b>
                                </div>
                                @foreach($section->questions as $question)
                                <br>
                                <div data-div-question-id="{{ $question->id }}" class="qustion question-parent
								
								 @if(isset($question->question_text))
								 paragraph
								 @endif 
								 ">
                                   <div class="question-text-style" 
								   {{-- @if(isset($question->paragraph)) style="flex-wrap:wrap;" @endif --}}
								   >
								    <div style="display:inline-flex">{{ switch_numbers(($loop->index+1), $exam->lang) }}</div>
                                    @if(isset($question->question_text))
									<div style="display:inline-flex;flex-wrap:wrap" class="is-q-text">{!! $question->question_text !!}</div>
                                    @endif
								   </div>
                                    @if(isset($question->paragraph))
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{ $question->id }}" aria-expanded="true" aria-controls="collapseOne" class="btn btn-sm js-btn-rotate btn-rotate">
                                        <i class="fa fa-angle-left rotate--90 transition-element" style=""></i>
                                    </a>
                                    @endif
                                    @if(isset($question->question_img))
                                    <img class="q-img" src="{{ Voyager::image($question->question_img, asset('images/blog/img1.jpg')) }}" alt="">
                                    @endif
                                </div>
                                @if(isset($question->paragraph))
                                <!-- Button trigger modal -->
                                <div class="paragraph" style="margin-top: 10px;">


                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
                                        <div class="panel panel-default">
                                            {{-- <div class="panel-heading" role="tab" id="headingOne"> --}}
                                            {{-- <h4 class="panel-title"> --}}
                                            {{-- <button class="btn" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{ $question->id }}" aria-expanded="true" aria-controls="collapseOne">
                                            القطعة
                                            </button> --}}
                                            {{-- <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        Collapsible Group Item #1
                                                    </a> --}}
                                            {{-- </h4> --}}
                                            {{-- </div> --}}
                                            <div id="collapseOne{{ $question->id }}" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    @if($exam->lang == 'ar')
                                                    {!! switch_numbers($question->paragraph, $exam->lang) !!}
                                                    @else
                                                    {!! $question->paragraph !!}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="paragraph-{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @if($exam->lang == 'ar')
                                                {!! switch_numbers($question->paragraph, $exam->lang) !!}
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="ans">
                                    @foreach($question->options as $option)
                                    <div class="ans-slide">
                                        @php($lang = $exam->lang)
                                        {{ ${'list_index_' . $exam->lang}[$loop->index + 1] }} -
                                        <label class="label_radio" for="radio-{{ $option->id }}">
                                            <input data-user-id="{{ auth()->user()->id }}" data-exam-id="{{ $exam->id }}" data-question-id="{{ $question->id }}" data-option-id="{{ $option->id }}" name="questions[{{ $question->id }}]answer" id="radio-{{ $option->id }}" class="js-cache-current-answer" value="{{ $option->id }}" type="radio" {{ old("radio-". $option->id) ? 'checked' : '' }} @if(getCache(getOldAnswerKey(auth()->user()->id , $exam->id , $question->id)) == $option->id)
                                            checked
                                            @endif
                                            >
                                            @if(isset($option->option_text))
											{!! $option->option_text !!}
                                            {{-- {!! switch_numbers($option->option_text, $exam->lang) !!} --}}
                                            @endif
                                            @if(isset($option->option_img))
                                            <img src="{{ Voyager::image($option->option_img, asset('images/certificate-logo.jpg')) }}" alt="">
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <hr style="border:2px dashed gray">
                                @endforeach
                            </div>
                            @endif
                            @endforeach
                            <div class="btn-slide" id="pagination">
                                <a href="javascript:" class="btn" id="previous">
                                    <i class="fa fa-angle-right"></i>
                                </a>
								@if($exam->sections->count()>1)
                                <a href="javascript:" class="btn" id="next">
                                    <i class="fa fa-angle-left"></i>
                                </a>
								@endif 
                            </div>
                            <div class="submit-quiz">
                                <button type="submit" class="btn" id="submit">إنهاء الإختبار</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/jquery.countdown.js') }}"></script>
<script>
    let minutes = parseInt("{{ $exam->exam_duration }}");
    let time_start = new Date().getTime();

    $('#countdown').countdown({
        timestamp: new Date().getTime() + minutes * 60 * 1000
        , callback: function(days, hours, minutes, seconds) {


            if (minutes == 1 && $('#show-exam-close-to-end').attr('data-value') == '0') {
                $('#show-exam-close-to-end').attr('data-value', 1);
                Swal.fire({
                    title: 'انتبه'
                    , text: 'متبقي علي انتهاء الامتحان اقل من دقيقه'
                    , confirmButtonText: 'حسناً'
                    , icon: 'info'
                    , timer: 3000,
					 customClass: 'swal-wide'
                })

            }
            let now = new Date().getTime();
            if (now > this.timestamp) {
                alert('تم انتهاء الوقت');
                $('#exam-from').submit();
                this.stopeed = true;
            }
        }
        , stopeed: false
    });

    $(function() {
        // Check if the form submitted by user or by javascript
        $('#submit').on('click', function(e) {
			if($('#user_submit').val() == 1){
				return true ;
			}
			e.preventDefault();
            const answeredAndNoneAnsweredQuestionIds = getAnsweredAndNonUnansweredQuestion();
            const nonAnsweredCount = answeredAndNoneAnsweredQuestionIds.nonAnswered.length;
            if (nonAnsweredCount) {
                Swal.fire({
                    title: 'متبقي ' + nonAnsweredCount + ' من الاساله لم يتم الاجابه عليهم .. هل تريد انهاء الاختبار ؟' 
                    , icon: 'question'
                    , iconHtml: '؟'
                    , confirmButtonText: 'نعم'
                    , cancelButtonText: 'لا'
                    , showCancelButton: true
                    , showCloseButton: true,
					 customClass: 'swal-wide',
                }).then(function(result){
					if(result.isConfirmed){
            		$('#user_submit').val(1);
					$('#submit').trigger('click');				
					}
					
				})
            }else{
				
				
				Swal.fire({
                    title: ' .. هل تريد انهاء الاختبار ؟' 
                    , icon: 'question'
                    , iconHtml: '؟'
                    , confirmButtonText: 'نعم'
                    , cancelButtonText: 'لا'
                    , showCancelButton: true
                    , showCloseButton: true,
					 customClass: 'swal-wide',
                }).then(function(result){
					if(result.isConfirmed){
            		$('#user_submit').val(1);
					$('#submit').trigger('click');				
					}
					
				})
				
			}
        });

        let page = 1;
        let sections = $('.sections');
        let prev = $('#previous');
        let next = $('#next');

        // Add style classes to sections' labels
        function addFillClass() {
            for (let i = 1; i < page; i++) {
                $('#section-' + i + '-title').addClass('fill');
            }
        }

        function addActiveClass(page) {
            $('#section-' + page + '-title').addClass('active');
        }

        // show/hide paragraph (if exist)
        $('body').on('click', '.toggleParagraph', function() {
            let id = $(this).data('id');
            let paragraph = $('#paragraph-' + id);
            paragraph.toggleClass('hidden');
            if (paragraph.hasClass('hidden')) {
                $(this).text('اظهار القطعة');
            } else {
                $(this).text('اخفاء القطعة');
            }
        });

        function hideSections() {
            sections.each(function(index, section) {
                $(section).hide();
                if ($('.sections#section-' + page).length) {
                    $('#section-' + page).fadeIn();
                }
            });
        }

        // show/hide sections
        hideSections();
        addFillClass();
        addActiveClass(page);
        prev.hide();
        next.on('click', function() {
            page++;
            addActiveClass(page);
            prev.show();
            hideSections();
            addFillClass();
            if (page >= sections.length) {
                $(this).hide();
            }
			document.getElementById('scroll-to').scrollIntoView();
        });

        prev.on('click', function() {
            page--;
            next.show();
            hideSections();
            addFillClass();
            if (page <= 1) {
                $(this).hide();
            }
			document.getElementById('scroll-to').scrollIntoView();
        });

        // submit the form if time end
        $('form#exam-from').submit(function() {
            let time_end = new Date().getTime();
            let time_spent = (time_end - time_start) / 1000;
            $('#time_spent').val(time_spent);
        });
    });

    $(document).on('click', '.js-cache-current-answer', function() {
        const token = document.documentElement.getAttribute('data-token');
        const userId = $(this).data('user-id');
        const examId = $(this).data('exam-id');
        const questionId = $(this).data('question-id');
        const optionId = $(this).data('option-id');
        $.ajax({
            url: "{{ route('exams.cache.old.answers') }}"
            , data: {
                '_token': token
                , userId
                , examId
                , questionId
                , optionId
            }
            , type: "post"
        })
    })
    $(document).on('click', '.js-btn-rotate', function() {
        $(this).find('i').toggleClass('rotate--90 rotate-90');
    })

    function getAnsweredAndNonUnansweredQuestion() {
        let answeredQuestion = [];
        let nonAnsweredQuestion = [];
        $('[data-div-question-id]').each(function(index, questionParent) {
            var currentQuestionId = $(questionParent).attr('data-div-question-id');
            var hasAnswer = $('input[name="questions[' + currentQuestionId + ']answer"]:checked').length;
            if (hasAnswer) {
                answeredQuestion.push(currentQuestionId)
            } else {
                nonAnsweredQuestion.push(currentQuestionId)

            }


        })
        return {
            answered: answeredQuestion
            , nonAnswered: nonAnsweredQuestion
        }
    }
$(function(){
	$('table').addClass('table table-bordered table-striped	table-hover');
})
</script>
@if($exam->lang != 'en')
<script>
	  String.prototype.EntoIn= function(e) {
      return this.replace(/\d/g, 
        d => e ? '٠١٢٣٤٥٦٧٨٩'[d] : '٠١٢٣٤٥٦٧٨٩'[d])
    }
	 String.prototype.IntoEn= function() {
      return this.replace(/[\u06F0-\u06F9\u0660-\u0669]/g, 
        d => ((c=d.charCodeAt()) > 1775 ? c - 1776 : c - 1632))
    }
	
	$('h١').replaceWith(function(){
    return $("<h1 />", {html: $(this).html()});
	});
	$('h٢').replaceWith(function(){
    return $("<h2 />", {html: $(this).html()});
	});
	$('h٣').replaceWith(function(){
    return $("<h3 />", {html: $(this).html()});
	});
	$('h٤').replaceWith(function(){
    return $("<h4 />", {html: $(this).html()});
	});
	$('h٥').replaceWith(function(){
    return $("<h5 />", {html: $(this).html()});
	});
	$('h٦').replaceWith(function(){
    return $("<h6 />", {html: $(this).html()});
	});
	$('.qustion span,.qustion p , .ans-slide span, .ans-slide p').each(function(index,element){
		var  translatedText = element.innerHTML.EntoIn();
		element.innerHTML = translatedText;
	})
	$('.qustion img , .ans-slide img,span img').each(function(index,img){
		var src = $(img).attr('src') ;
		var height = $(img).attr('height') ;
		var width = $(img).attr('width') ;
		console.log(img,src,height,width,'--')
		$(img).attr('src',src.IntoEn())
		if(width){
			$(img).attr('width',width.IntoEn())
		}
		if(height){
			$(img).attr('height',height.IntoEn())
		}
	
	})
</script>
@endif
@endsection
