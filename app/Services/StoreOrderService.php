<?php
namespace App\Services;

use App\Course;
use App\Order;
use App\ReservationModel;
use App\services\AcceptService;
use Illuminate\Http\Request;

class StoreOrderService
{
    private $acceptService ;

    public function __construct(AcceptService $acceptService)
    {
        $this->acceptService = $acceptService ;
    }
    public function execute(string $firstName  , string $lastName , string $phone , string $email  ,   string $productName , string $productDescription , float $price ,int $quantity , float $discount = 0    ):array
    {

		$totalPrice = $price*$quantity - $discount ;
		
		$totalPriceInCents = convertMoney($totalPrice,'SAR','EGP') * 100 ;
		if(is_null($totalPriceInCents)){
			return [
				'status'=>false,
				'message'=>'Invalid In Currency Convert Service'
			];
		}
		$totalPriceInCents = round($totalPriceInCents);
		// dd($totalPriceInCents);
		

        // $paid = in_array('admin' , Request()->segments()) && $request->payment_type == Order::CASH  ? $request->paid :  '0';

        // $payment_type = $request->payment_type ;

        // $course = Course::where('id',$request->input('course_id'))->first();

        // $courseName=$course->name_en  ;

        // $price = $course->price   ;
        // $discount = ($request->discount > 0 ? $request->discount : 0);

// dd( ( $request->get('total_price_custom')  != (($price * $request->input('quantity')) - $discount )));

		// $total_price_has_changed = $request->get('total_price_custom')  != (($price * $request->input('quantity')) - $discount ) ;

        // if($request->get('total_price_custom') && ( $total_price_has_changed ) ){
        //     $price = $request->get('total_price_custom') ;
        //     $totalPrice = $request->get('total_price_custom') - $discount ;

        // }
        // else {
            // $price = $course->price ;
        // }

        // $totalPrice = $request->get('total_price_custom') ?  : ($price * $request->input('quantity')) - $discount ;
        // $firstName = $request->first_name ;
        // $lastName = $request->last_name ;

        // $fullName = $firstName . ' ' . $lastName ;
        // $phone = $request->phone ;
        // $email = $request->email ;
// dd($fullName);


        // if($payment_type != Order::CASH)
        {




            $response =  $this->acceptService->getAuthToken();

            if(isset($response->token))
            {

                $res = $this->acceptService->createInvoice([
                    "auth_token"=>$response->token,
                    "api_source"=>"INVOICE",
                    "amount_cents"=>$totalPriceInCents,
                    "delivery_needed"=>"false",
                    // "currency"=>'SAR',
                    "currency"=>getPaymentServiceCurrency(),
                    "shipping_data"=>[
                        "first_name"=>$firstName,
                        "last_name"=>$lastName,
                        "phone_number"=>$phone,
                        "email"=>$email
                    ],

                    "integrations"=>AcceptService::getPaymentIntegrations(),
                    "items"=>[
                        [
                            "name"=>$productName,
                            "amount_cents"=>$totalPrice * 100,
                            "quantity"=>$quantity  ,
                            "description"=>$productDescription
                        ]
                    ]


                ] , $response->token);
                if(isset($res->id))
                {
                
                    $paymentToken = ($this->acceptService->sendApiRequestFor("https://accept.paymob.com/api/acceptance/payment_keys" , [
                        'auth_token'=>$response->token ,
                        "amount_cents"=>$totalPriceInCents ,
                        "expiration"=> 36000000,
                        "order_id"=>$res->id ,
                        "billing_data"=> [
                            "apartment"=> "n/a",
                            "email"=> $email,
                            "floor"=> "n/a",
                            "first_name"=> $firstName,
                            "street"=> "n/a",
                            "building"=> "n/a",
                            "phone_number"=> $phone,
                            "shipping_method"=> "n/a",
                            "postal_code"=> "n/a",
                            "city"=> "n/a",
                            "country"=> "n/a",
                            "last_name"=> $lastName,
                            "state"=> "n/a"
                        ],
						
                        "currency"=> getPaymentServiceCurrency(),
                        "integration_id"=> AcceptService::getPaymentIntegration(),
                        "lock_order_when_paid"=> "false"
                    ]));
					// dd($paymentToken);
                    if(isset($paymentToken->token))
                    {
                        $paymentToken = $paymentToken->token ;
                        // $fram = AcceptService::getPaymentFrame($paymentToken);

                        // $order = Order::create([
                        //     'invoice_id'=>$res->id ,
                        //     'order_id'=>$res->id ,
                        //     'created_by'=>auth()->user()->getName() ,
                        //     'created_at'=>now(),
                        //     'name'=>$fullName ,
                        //     'phone'=>$phone,
                        //     'email'=>$email,
                        //     'course_id'=>$productId,
                        //     'quantity'=>$quantity,
                        //     'discount'=>$discount,
                        //     'payment_token'=>$paymentToken ,
                        //     'price'=>$price ,
                        //     'total_price'=>$totalPrice,
                        //     'payment_link'=>$res->url ,
                        //     'paid'=>false ,
                        //     'address'=>$address ,
                        //     'course_date'=>$request->course_date,
                        //     'user_id'=>$userId ,
                    

                        // ]);
// dd($res);
                        return [
                            // 'order'=>$order ,
                            'token'=>$paymentToken ,
                            'status'=>true,
							'payment_link'=>$res->url,
							'order_id'=>$res->id
                        ] ;
                    }

                }

                return [
                    'status'=>false
                ];


            }

            return [
                    'status'=>false
                ]; ;

        }

		
		// if cash 

//         else {
//             $order = Order::create([
//                 'invoice_id'=>0  ,
//                 'order_id'=>generateRandomOrderId() ,
//                 'created_by'=>$request->created_by ?? optional(Auth()->user())->name ,
//                 'created_at'=>now(),
//                 'name'=>$fullName ,
//                 'phone'=>$request->input('phone'),
//                 'email'=>$request->input('email'),
//                 'course_id'=>$request->input('course_id'),
//                 'quantity'=>$request->input('quantity'),
//                 'discount'=>$discount,
//                 'payment_token'=>null  ,
// //                    'expired'=>$request->input('expired'),
//                 'price'=>$price ,
//                 'total_price'=>$totalPrice,
//                 'payment_link'=>'',
//                 'paid'=>$paid ,
//                 'type'=>$request->type ,
//                 'address'=>$request->address ,
//                 'payment_type'=>$request->payment_type ,
//             ]);

//             if($paid)
//             {
//                 $reserveModel = new \Illuminate\Http\Request();

//                 $reserveModel->replace([
//                     'name'=>[
//                         'en'=>$fullName ,
//                         'ar'=>$fullName
//                     ] ,
//                     'address'=>$request->address  ,
//                     'contact_phone'=>$request->input('phone') ,
//                     'type'=>$request->type  ,  // company or whatsoover
//                     'email'=>$email ,
//                     'course_id'=>$request->course_id ,
//                     'created_at'=>now() ,
//                 ]);

//                 ReservationModel::store($reserveModel , $order->quantity , $order  , Order::CASH);
//             }
//             return [
//                 'order'=>$order ,
//                 'status'=>true ,

//             ] ;
//         }


         }
}
