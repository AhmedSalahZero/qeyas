<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookRequest;
use App\CourseRequest;
use App\Exam;
use App\ExamReport;
use App\ExamRequest;
use App\Payment;
use App\Services\AcceptService;
use App\Services\StoreOrderService;
use App\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{
    protected $provider;
    public function __construct() {
        $this->provider = new ExpressCheckout();
    }

    public function checkout_book(Request $request) {
        if(! $request->has('book_id')){
            return back()->with('fail', 'هناك خطأ .. حاول مرة اخرى');
        }

        $book = Book::find($request->book_id);
        $payment = Payment::create([
            'invoice_id' => time().uniqid(),
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'price' => $book->book_price
        ]);

        $data = $this->getBook($book, $payment->invoice_id);

        $response = $this->provider->setExpressCheckout($data);
        $payment->update(['token' => $response['TOKEN']]);
        return redirect($response['paypal_link']);
    }

    public function checkout_book_success(Request $request) {
        $token = $request->token;
        $book = Book::find($request->book_id);
        $PayerID = $request->PayerID;
        $response = $this->provider->getExpressCheckoutDetails($token);
        $invoice_id = $response['INVNUM'];
        if(! in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])){
            return redirect()->route('books.buy', $book)->with('fail', 'خطأ في عملية الدفع,, حاول مرة اخرى');
        }
        $data = $this->getBook($book, $invoice_id);
        $payment_status = $this->provider->doExpressCheckoutPayment($data, $token, $PayerID);
        $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
        if(strtolower($status) == 'completed' ){
            $payment = Payment::where('token', $request->token)->first();
            $payment->update(['status' => 'approved']);
            $title = 'عملية الدفع - '.$book->book_title;
            $msg = 'تمت عملية الشراء بنجاح';
            UserNotification::create([
                'type' => 'private',
                'user_id' => auth()->id(),
                'content' => $title . ' ' . $msg
            ]);
            BookRequest::create([
                'user_id' => $payment->user_id,
                'book_id' => $book->id,
                'status' => 'approved'
            ]);
            return redirect()->route('books.show', $book)->with('success', 'تم شراء الكتاب بنجاح');
        }
        return back()->with('fail', 'حدث خطأ');
    }

    public function getBook($book, $invoice) {
        return [
            'items' => [
                [
                    'name' => $book->book_title,
                    'price' => $book->book_price,
                    'desc' => 'شراء كتاب من قياس 2030',
                    'qty' => 1
                ]
            ],
            'invoice_id' => $invoice,
            'invoice_description' => 'شراء كتاب من قياس 2030',
            'total' => $book->book_price,
            'shipping_discount' => 0,
            'return_url' => route('books.checkout_success', ['book_id' => $book->id]),
            'cancel_url' => route('books.show', $book)
        ];
    }

    public function checkout_exam(Request $request) {
        if(! $request->has('product_id')){
            return back()->with('fail', 'هناك خطأ .. حاول مرة اخرى');
        }
		$productDescription = $request->get('product_description');
		$price = $request->get('price');
        $modelName = $request->get('model_name');
		$fullModelName = '\App\\'.$modelName;
		$quantity =  $request->get('quantity')  ;
		$productId = $request->get('product_id');
		$product = $fullModelName::find($productId);
		// $failRedirectRoute = route('home');
		$failedRouteName = 'home';
		$failedRouteParams = [];
		// dd($product);
		$paymentArr  = [
            'invoice_id' => $invoiceId  = time().uniqid(),
            'user_id' => auth()->id(),
            'price' => $price,
			'status'=>'awaiting' 
        ];
		$additionalPaymentInfo = [];
		if($modelName == 'Exam'){
			$additionalPaymentInfo = [          'exam_id' => $productId];
			$failedRouteName = 'exams.show';
			$failedRouteParams = ['exam'=>$productId] ;	
		}
		if($modelName =='Course'){
			$additionalPaymentInfo = [          'course_id' => $productId];
			$failedRouteName = 'courses.show';
			$failedRouteParams = ['course'=>$productId] ;			
		}
		if($modelName =='Book'){
			$additionalPaymentInfo = [          'book_id' => $productId];
			$failedRouteName = 'books.show';
			$failedRouteParams = ['book'=>$productId] ;
			
		}
		$paymentArr = array_merge($paymentArr , $additionalPaymentInfo);
        $payment = Payment::create($paymentArr);
		// 		dd($product);
		$storeOrderService= new StoreOrderService(new AcceptService); 
		$user = auth()->user();
		$fullName = $user->getName();
		$fullNameExploded = getFirstAndLastNameFromName($fullName);
		$firstName = $fullNameExploded['first_name'];
		$lastName = $fullNameExploded['last_name'] ?: $firstName;
		$phone = $user->getPhone();
		$email = $user->getEmail();
		if(env('APP_ENV') =='local'){
			$phone ='01025894984';
			$email = 'asalahdev5@gmail.com';
		}
		
		// dd($user);
		if(!$email){
			Cache::forever('failMessage_'.$user->id,'برجاء الدخول علي البروفايل الخاص بك واضافه البريد الالكتروني');
			return redirect()->route($failedRouteName,$failedRouteParams)->with('fail','برجاء الدخول علي البروفايل الخاص بك واضافه البريد الالكتروني');
		}
		if(!$phone){
			Cache::forever('failMessage_'.$user->id,'برجاء الدخول علي البروفايل الخاص بك واضافه رقم هاتفك');
			return redirect()->route($failedRouteName,$failedRouteParams)->with('fail','برجاء الدخول علي البروفايل الخاص بك واضافه رقم هاتفك');
		}
		$productName = $product->getTitle();
		$discount = 0;
		// $productDescription = ;
		$response = $storeOrderService->execute($firstName , $lastName , $phone , $email , $productName ,$productDescription, $price , $quantity , $discount   );
		// dd($response);
		if(isset($response['status']) && $response['status']){
			$payment->update(['token' => $response['token'],'order_id'=>$response['order_id']]);
			return redirect()->route('payment.pay',[ 'invoice_id'=>$invoiceId]);
		}
	
		return redirect()->route('home')->with('fail',__('فشلت عمليه الدفع برجاء المحاوله في وقت اخر'))
    ;}

    // public function checkout_exam_success(Request $request) {
    //     $token = $request->token;
    //     $exam = Exam::find($request->exam_id);
    //     $PayerID = $request->PayerID;
    //     $response = $this->provider->getExpressCheckoutDetails($token);
    //     $invoice_id = $response['INVNUM'];
    //     if(! in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])){
    //         return redirect()->route('exams.buy', $exam)->with('fail', 'خطأ في عملية الدفع,, حاول مرة اخرى');
    //     }
    //     $data = $this->getExam($exam, $invoice_id);
    //     $payment_status = $this->provider->doExpressCheckoutPayment($data, $token, $PayerID);
    //     $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
    //     if(strtolower($status) == 'completed' ){
    //         $payment = Payment::where('token', $request->token)->first();
    //         $payment->update(['status' => 'approved']);
    //         $title = 'عملية الدفع - '.$payment->exam->title;
    //         $msg = 'تمت عملية الشراء بنجاح';
    //         UserNotification::create([
    //             'type' => 'private',
    //             'user_id' => auth()->id(),
    //             'content' => $title . ' ' . $msg
    //         ]);
    //         ExamRequest::create
    //         (
    //             [
    //                 'user_id' => $payment->user_id,
    //                 'exam_id' => $payment->exam_id,
    //                 'status' => 'approved'
    //             ]
    //         );
    //         return redirect()->route('exams.show', $exam)->with('success', 'تم شراء الاختبار بنجاح');
    //     }
    //     return back()->with('fail', 'حدث خطأ');
    // }

    public function getExam($exam, $invoice) {
        return [
            'items' => [
                [
                    'name' => $exam->title,
                    'price' => $exam->exam_price,
                    'desc' => 'شراء اختبار من قياس 2030',
                    'qty' => 1
                ]
            ],
            'invoice_id' => $invoice,
            'invoice_description' => 'شراء اختبار من قياس 2030',
            'total' => $exam->exam_price,
            'shipping_discount' => 0,
            'return_url' => route('exams.checkout_success', ['exam_id' => $exam->id]),
            'cancel_url' => route('exams.show', $exam)
        ];
    }
	public function successCallback(Request $request)
	{
		// dd($request->all());
		$order_id = $request->get('order');
		$payment = Payment::where('order_id',$order_id)->first();
		if( $request->get('success') == 'false'){
			$title = '';
			if($payment->exam_id){
				$title = $payment->exam->title;
			}elseif($payment->course_id){
				$title = $payment->course->title;
			}elseif($payment->book_id){
				$title = $payment->book->getName();
			}
			
			$title = 'عملية الدفع - '.$title;
            $msg = 'فشلت عملية الشراء ';
			UserNotification::create([
                'type' => 'private',
                'user_id' => $payment->user_id,
                'content' => $title . ' ' . $msg
            ]);
			if($payment->exam_id){
				return redirect()->route('exams.show',['exam'=>$payment->exam_id])->with('fail',__('فشلت عملية الدفع .. برجاء المحاولة مرة اخرى'));
			}
			if($payment->course_id){
			return redirect()->route('courses.show',['course'=>$payment->course_id])->with('fail',__('فشلت عملية الدفع .. برجاء المحاولة مرة اخرى'));	
			}
			if($payment->book_id){
				return redirect()->route('books.show',['course'=>$payment->book_id])->with('fail',__('فشلت عملية الدفع .. برجاء المحاولة مرة اخرى'));
			}
			
		}
		$payment->update([
			'status'=>'approved',
			'transaction_id'=>$request->get('id')
		]);
		if($payment->exam_id){
			
			$title = 'عملية الدفع - '.$payment->exam->title;
            $msg = 'تمت عملية الشراء بنجاح';
            UserNotification::create([
                'type' => 'private',
                'user_id' => $payment->user_id,
                'content' => $title . ' ' . $msg
            ]);
		
            ExamRequest::create
            (
                [
                    'user_id' => $payment->user_id,
                    'exam_id' => $payment->exam_id,
                    'status' => 'approved',
					'payment_id'=>$payment->id,
					'is_free'=>0
					
                ]
            );
			
			return redirect()->route('exams.show',['exam'=>$payment->exam_id])->with('success',__('تم الشراء بنجاح'));
		}
		if($payment->course_id){
			
			$title = 'عملية الدفع - '.$payment->course->title;
            $msg = 'تمت عملية الشراء بنجاح';
            UserNotification::create([
                'type' => 'private',
                'user_id' => $payment->user_id,
                'content' => $title . ' ' . $msg
            ]);
			CourseRequest::where('course_id',$payment->course_id)->where('user_id',$payment->user_id)->update([
				'status'=>'approved',
				'payment_id'=>$payment->id
				
			]);
			return redirect()->route('courses.show',['course'=>$payment->course_id])->with('success',__('تم الشراء بنجاح'));
		}
		
		if($payment->book_id){
			
			$title = 'عملية الدفع - '.$payment->book->getName();
            $msg = 'تمت عملية الشراء بنجاح';
            UserNotification::create([
                'type' => 'private',
                'user_id' => auth()->id(),
                'content' => $title . ' ' . $msg
            ]);
			BookRequest::where('book_id',$payment->book_id)->where('user_id',$payment->user_id)->update([
				'status'=>'approved',
				'payment_id'=>$payment->id
				
			]);
			return redirect()->route('books.show',['course'=>$payment->book_id])->with('success',__('تم الشراء بنجاح.. ستتم عمليه الشحن علي العنوان المذكور في مده لا تتخطى سبع ايام عمل'));
		}
		return redirect()->route('home')->with('success',__('تم الشراء بنجاح'));
		
	}
	public function sendRefundOrder(Request $request){
		$payment = Payment::where('id',Request()->segment(2))->where('user_id',auth()->user()->id)->first();
		if(!$payment->canBeRefunded()){
			return redirect()->back()->with('fail','لا يمكن تنفيذ طلبك');
		}
		
		
		
		// $payment = Payment::where('invoice_id',$request->get('invoice_id')->where('user_id',auth()->user()->id)->firstOrFail());
		
		$acceptService = new AcceptService();
		$authToken =$acceptService->getAuthToken();
		if($authToken->token){
			$isSent = $acceptService->sendRefundOrder($payment->getTransActionId() , $authToken->token) ;
			if($isSent){
				$payment->update([
					'status'=>'refunded'
				]);
				auth()->user()->update([
					'has_refunded'=>1
				]);
				
				if($payment->exam_id){
					$examRequest = ExamRequest::where('exam_id',$payment->exam_id)->first();
					$examRequest->update([
						'status'=>'refunded'
					]);
					
				}
				if($payment->course_id){
					$courseRequest = CourseRequest::where('course_id',$payment->course_id)->first();
					$courseRequest->update([
						'status'=>'refunded'
					]);
					
				}
				if($payment->book_id){
					$bookRequest = BookRequest::where('book_id',$payment->book_id)->first();
					$bookRequest->update([
						'status'=>'refunded'
					]);
					
				}
				return redirect()->back()->with('success','تم ارسال طلب استرجاع الاموال الي البنك');
			}
		}
		
		return redirect()->back()->with('fail','حدث خطا اثناء ارسال طلبك ');
		
		
	}
}
