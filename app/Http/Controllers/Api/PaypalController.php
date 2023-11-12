<?php

namespace App\Http\Controllers\Api;

use App\Exam;
use App\ExamRequest;
use App\Http\Controllers\Controller;
use App\Payment;
use App\UserNotification;
use App\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\AdaptivePayments;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaypalController extends Controller
{
    public function request(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'exam_id' => 'required|exists:exams,id'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $exam = Exam::where('id',$request->exam_id)->select('id','title','exam_price')->first();

        $payment = Payment::create
        (
            [
                'invoice_id' => time().uniqid(),
                'user_id' => $request->user_id,
                'exam_id' => $request->exam_id,
                'price' => $exam->exam_price
            ]
        );

        $data = [];
        $data['items'] =
            [
                [
                    'name' => $exam->title,
                    'price' => $exam->exam_price,
                    'desc'  => 'شراء إختبار من قياس 2030',
                    'qty' => 1
                ]
            ];

        $data['invoice_id'] = $payment->invoice_id;
        $data['invoice_description'] =  'شراء إختبار '. $exam->title .' من قياس 2030';
        $data['total'] = $exam->exam_price;
        $data['shipping_discount'] = 0;

        $data['return_url'] = url('/api/payment/success');
        $data['cancel_url'] = url('/api/payment/failed');

        $provider = new ExpressCheckout();      // To use express checkout.

        $response = $provider->setExpressCheckout($data);
        $payment->update(['token' => $response['TOKEN']]);

        return response()->json(['status' => 'success', 'link' => $response['paypal_link']]);
    }


    // public function fallback($status)
    // {
    //     $payment = Payment::where('token', Input::get('token'))->first();

    //     if($status == 'success')
    //     {
    //         $provider = new ExpressCheckout();      // To use express checkout.
    //         $response = $provider->getExpressCheckoutDetails($payment->token);

    //         $payer_id = Input::get('PayerID');
    //         if($payment && $payer_id && $payer_id == $response['PAYERID'])
    //         {
    //             $payment->update(['status' => 'approved']);

    //             ExamRequest::create
    //             (
    //                 [
    //                     'user_id' => $payment->user_id,
    //                     'exam_id' => $payment->exam_id,
    //                     'status' => 'approved',
	// 					'payment_id'=>$payment->id
    //                 ]
    //             );

    //             $tokens = UserToken::where('user_id', $payment->user_id)->pluck('token');
    //             $title = 'عملية الدفع - '.$payment->exam->title;
    //             $msg = 'تمت عملية الشراء بنجاح';

    //             UserNotification::create
    //             (
    //                 [
    //                     'type' => 'private',
    //                     'user_id' => $payment->user_id,
    //                     'content' => $title . ' ' . $msg
    //                 ]
    //             );

    //             UserNotification::send($tokens,$title,$msg);

    //             return '<div id="status">success</div><div id="msg">exam_purchased</div>';
    //         }

    //         $tokens = UserToken::where('user_id', $payment->user_id)->pluck('token');
    //         $title = 'عملية الدفع - '.$payment->exam->title;
    //         $msg = 'خطأ في بيانات عملية الشراء';

    //         UserNotification::create
    //         (
    //             [
    //                 'type' => 'private',
    //                 'user_id' => $payment->user_id,
    //                 'content' => $title . ' ' . $msg
    //             ]
    //         );

    //         UserNotification::send($tokens,$title,$msg);

    //         return '<div id="status">failed</div><div id="msg">invalid_payment_info</div>';
    //     }
    //     else
    //     {
    //         $tokens = UserToken::where('user_id', $payment->user_id)->pluck('token');
    //         $title = 'عملية الدفع - '.$payment->exam->title;
    //         $msg = 'تم إلغاء عملية الدفع من طرفكم';

    //         UserNotification::create
    //         (
    //             [
    //                 'type' => 'private',
    //                 'user_id' => $payment->user_id,
    //                 'content' => $title . ' ' . $msg
    //             ]
    //         );

    //         UserNotification::send($tokens,$title,$msg);

    //         return '<div id="status">failed</div><div id="msg">payment_canceled</div>';
    //     }
    // }
}
