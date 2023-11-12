<?php

namespace App\Http\Controllers;

use App\BookRequest;
use App\Category;
use App\Exam;
use App\ExamQuestion;
use App\ExamReport;
use App\ExamRequest;
use App\ExamTry;
use App\Http\Controllers\Api\ExamController;
use App\Payment;
use App\Services\AcceptService;
use App\UserAnswer;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use TCG\Voyager\Traits\AlertsMessages;

class ExamsController extends Controller
{
    use AlertsMessages;
    public function index() {
        $exams = Exam::where('available', 1)->paginate(10);
		
		// dd()
        $title = 'جميع الاختبارات';
        return view('exams.index', compact('exams', 'title'));
    }

    public function show(Exam $exam) {
		if(! $exam->available) {
			abort(401, 'هذا الاختبار غير متاح في الوقت الحالي');
        }
        if($exam->exam_type == 'paid' && $exam->exam_price > 0 && ! Auth::user()->has_exam($exam->id)) {
			return redirect()->route('exams.buy', $exam);
        }

        $title = $exam->title;
        return view('exams.show', compact('exam', 'title'));
    }

    public function buy(Exam $exam) {
		// $title='wqqq';
		// $headerTitle = 'إختبارات قياس';
		$breadCrumbTitle ='إختبارات قياس';
		$breadCrumbLink = route('exams.index');
		$breadCrumbLastTitle = 'شراء اختبار';
		$price = $exam->exam_price ;
		$modelName ='Exam';
		$productName = $exam->getName();
		$productDescription='شراء اختبار من قياس 2030';
		$quantity = 1 ;
		$productId = $exam->id ;
		
		// return view('exams.buy', compact('exam', 'title','breadCrumbTitle','breadCrumbLastTitle','price','productName','breadCrumbLink','productDescription','quantity','modelName','productId'));
        if(! $exam->available) {
            abort(401, 'هذا الاختبار غير متاح في الوقت الحالي');
        }
		// dd($exam->exam_type=='free' ,!ExamRequest::where('user_id',auth()->user()->id)->where('exam_id',$exam->id)->exists());
		// dd(Auth::user()->has_exam($exam->id));
        if($exam->exam_type == 'free' || $exam->exam_price == 0 || Auth::user()->has_exam($exam->id)) {
			if($exam->exam_type == 'free' && !ExamRequest::where('user_id',auth()->user()->id)->where('exam_id',$exam->id)->exists()){
				$examRequest = ExamRequest::create([
					'user_id'=>auth()->user()->id ,
					'exam_id'=>$exam->id ,
					'is_free'=>1 ,
					'status'=>'approved'
				]);
			}
            return redirect()->route('exams.show', $exam);
        }
        $title = 'شراء اختبار';
		
        return view('exams.buy', compact( 'title','breadCrumbTitle','breadCrumbLastTitle','price','productName','breadCrumbLink','productDescription','quantity','modelName','productId'));
    }

    public function start(Exam $exam) {
        $title = $exam->title;
        $sections = $exam->sections;
        return view('exams.start', compact('exam', 'title', 'sections'));
    }

    public function post_exam(Request $request) {
        $exam = Exam::find($request->exam_id);
		$totalQuestionNumber = $exam->questions->count();
		// dd();
        if($request->userSubmit) {
            if(! isset($request->questions) || count($request->questions) < $exam->questions->count()) {
                // return back()->withErrors('يجب الاجابة على جميع الاسئلة لانهاء الاختبار');
            }
        }
        $right_answers = 0;
        $wrong_answers = 0;

        // if(! is_null($request->questions)) 
		// {


            foreach((array)$request->questions as $question => $answer) {
                $_question = ExamQuestion::find($question);
                $user_answer = $answer;
                $right_answer = $_question->right_answer_id;
                if($user_answer == $right_answer) {
                    $right_answers++;
                } else {
                    $wrong_answers++;
                }
            }
            $time_spent = gmdate('H:i:s', $request->time_spent);
            $percentage = ceil(($right_answers / $exam->questions->count()) * 100);
            $try = new ExamTry;
            $try->exam_id = $exam->id;
            $try->user_id = Auth::id();
            $try->result = $right_answers . '/' . $exam->questions->count();
            $try->percentage = $percentage;
            $try->time_spent = $time_spent;
            $try->num_passed_questions = $right_answers;
            $try->num_failed_questions = $wrong_answers;
            $try->save();


            foreach((array)$request->questions as $q => $a) {
                $user_answers = new UserAnswer;
                $user_answers->exam_try_id = $try->id;
                $user_answers->user_id = Auth::id();
                $user_answers->question_id = $q;
                $user_answers->answer_id = $a;
                $user_answers->right_answer_id = ExamQuestion::find($q)->right_answer_id;
                $user_answers->save();
            }

            $exam_report = ExamReport::where('exam_id', $exam->id)->where('user_id', \Auth::id())->first();
            $report = $exam_report ?? new ExamReport;
            $report->num_tries++;
            $report->exam_id = $exam->id;
            $report->user_id = Auth::id();
            $report->highest_result = $report->highest_result > $percentage ? $report->highest_result : "$percentage%";
            $report->last_try_date = Carbon::now();
            $report->time_spent = $time_spent;
            $report->save();

            return view('exams.result', compact(
                'exam',
                'time_spent',
                'percentage',
                'wrong_answers',
                'right_answers',
				'totalQuestionNumber'
            ));
        // }
        // return view('exams.failed', compact('exam'));
    }

    public function toplist(Exam $exam) {
        $title = 'قائمة الافضل';
        $top_students = $exam->reports()->orderBy('highest_result', 'desc')->take(10)->get();
        return view('exams.toplist', compact('title', 'top_students', 'exam'));
    }

    public function report(ExamReport $report) {
        $tries = ExamTry::where('exam_id', $report->exam_id)->where('user_id', Auth::id())->get();
        return view('exams.report', compact('report', 'tries'));
    }

    public function search(Request $request) {
		$exams = new Exam;
		//        if(isset($request->exam_type)){
			//            $exams = $exams->whereIn('exam_type', $request->exam_type);
			//        }
			if($request->free_exam == 1) {
				$exams = $exams->where('exam_type', 'free')->orWhere('exam_price', 0);
			}
			if($request->paid_exam == 1) {
				$exams = $exams->where('exam_type', 'paid')->orWhere('exam_price', '!=', 0);
			}
			if(isset($request->categories)){
				$mainCategories = Category::whereIn('id',$request->categories)->with('sub_categories')->get()->pluck('sub_categories')->toArray();
				$subCategories = getIds($mainCategories);
				$exams = $exams->whereIn('category_id', $subCategories);
			}
        if(isset($request->from_price)){
            $exams = $exams->where('exam_price', '>=', $request->from_price);
        }
        if(isset($request->to_price)){
            $exams = $exams->where('exam_price', '<=', $request->to_price);
        }
        if(isset($request->q)){
            $exams = $exams->where('title', 'like', "%$request->q%");
        }
        $exams = $exams->paginate(10);

        return view('exams.search', compact('exams'));
    }
	public function cacheOldAnswers(Request $request)
	{
		$userId = $request->get('userId');
		$examId = $request->get('examId');
		$questionId = $request->get('questionId');
		$optionId = $request->get('optionId');
		$key = getOldAnswerKey($userId , $examId , $questionId);
		Cache::forever($key,$optionId);
	}
	public function active(Exam $exam){
		// dd($exam);
		$exam->available = 1 ;
		$exam->save();
		return back()->with($this->alertSuccess('تم تفعيل الامتحان'));
	}
	public function showPaymentPage($invoice_id)
	{
		// dd($invoice_id);
		$acceptService = new AcceptService;
		$payment = Payment::where('invoice_id',$invoice_id)->firstOrFail();
		$product = $payment->getProductFromPayment() ;
		$fullModelName = get_class($product) ;
		$fullModelName = explode('\\', $fullModelName);
		$modelName = end($fullModelName);
		// $modelName = getClassNameFromNamespace($modelName);
		// dd($product);
		// dd($modelName);
		$quantity = $modelName == 'Book' ? BookRequest::where('user_id',$payment->user->id)->where('book_id',$product->id)->first()->no_books : 1 ;
		//  dd($quantity,$payment->user->id);
		$price = $payment->getPrice();
		$paymentFrame = $acceptService->getPaymentFrame($payment->getPaymentToken());
		return view('exams.purchase',[
			'product'=>$product , 
			'price'=>$price , 
			'paymentFrame'=>$paymentFrame,
			'modelName'=>$modelName,
			'quantity'=>$quantity
		]);
	}
}
