<?php

namespace App\Http\Controllers;
use App\Course;
use App\CourseRequest;
use App\Exports\CourseReportExcel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use TCG\Voyager\Traits\AlertsMessages;

class CoursesController extends Controller
{
    use AlertsMessages;
    public function index() {
        $courses = Course::orderBy('order')->paginate(10);
        $title = 'الدورات التدريبية';
        return view('courses.index', compact('courses', 'title'));
    }

    public function show(Request $request, $course) {
        // $title = $course->course_title;
		$segment = $request->segment(2);
		if(in_array($segment,Course::getCoursesTypes())){
			$typeId = $segment == 'مسجلة' ? 0 :1 ;
			$courses = Course::where('type',$typeId)->where('active',1)->paginate(10);
			return view('courses.index',[
				'courses'=>$courses 
			]);
		}
		$course = Course::where('id',$course)->firstOrFail();
		
		$title = $course->getName();
        return view('courses.show', compact('course', 'title'));
    }

    public function request(Request $request, Course $course) {
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'phone' => 'required',
            'message' => 'nullable|string'
        ]);
        $user = Auth::user();
        $course->requests()->create([
            'user_id' => $user->id,
            'status' => $course->isFree() ? 'approved' :'awaiting',
            'user_name' => $request->name,
            'user_phone' => $request->phone,
            'message' => $request->message,
			'is_free'=> $course->isFree(),
			'price'=>$course->getPrice()
        ]);
		
		if(!$course->isFree()){
			
			$breadCrumbTitle ='دورات قياس';
		$breadCrumbLink = route('courses.index');
		$breadCrumbLastTitle = 'شراء دورة تدربية';
		$price = $course->getPrice() ;
		$modelName ='Course';
		$productName = $course->getName();
		$productDescription='شراء دورة تدربية من قياس 2030';
		$quantity = 1 ;
		$productId = $course->id ;
		// dd($product);
		$title = 'شراء دورة تدربية';
        return view('exams.buy', compact( 'title','breadCrumbTitle','breadCrumbLastTitle','price','productName','breadCrumbLink','productDescription','quantity','modelName','productId'));
   
		}
		
        return back()->with('message', 'تم ارسال الطلب بنجاح');
    }

    public function search(Request $request) {
		$courses =Course::when($request->has('type'),function(Builder $builder) use($request){
			
			$builder->where('type',$type);
		})
		->when($request->free_course ,function(Builder $builder) {
			 $builder->where('course_price', 0);
			
		})->when($request->paid_course ,function(Builder $builder) {
			 $builder->where('course_price', '!=',0);
		})
		->when($request->has('q') && $request->get('q') , function(Builder $builder) use ($request){
			$builder->where('course_title', 'like', "%$request->q%");
		})->paginate(10)->appends($request->all());
		
        return view('courses.search', compact('courses'));
    }
	public function active(Course $course){
		$course->active = 1 ;
		$course->save();
		return back()->with($this->alertSuccess('تم تفعيل الدورة'));
		
	}
	public function report(Course $course)
	{
		$courses = [];
		CourseRequest::where('course_id',$course->id)->with('user')->get()->each(function($courseRequest) use (&$courses){
			$courses[] = [
				'name'=>$courseRequest->user  ? $courseRequest->user->getName() : '-',
				'phone'=>$courseRequest->user  && $courseRequest->user->getPhone()? $courseRequest->user->getPhone() : '-',
				'date'=>formatDateForView($courseRequest->created_at),
				'payment_status'=>getPaymentStatusInArr($courseRequest->status)
			];
		
		});
		return response()->json([
			'id'=>$course->id,
			'no_students'=>count($courses),
			'name'=>$course->getName(),
			'users'=>$courses
		]);
		
	}
}
