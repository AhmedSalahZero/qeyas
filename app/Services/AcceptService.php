<?php

namespace App\Services;

class AcceptService
{

    private   $requestType  , $apiToken , $apiPointUrlStatus ;

    public function __construct()
    {

        $this->apiToken = 'Authorization: Bearer '. env('accept_api_key') ;

        $this->apiPointUrlStatus ='https://accept.paymob.com/api/auth/tokens';
//
        $this->requestType = 'POST';
//
//        $this->apiToken = 'Authorization: Bearer '. env('myfatoorah_api_token');
    }

    public function getAuthToken()
    {
        return $this->sendApiRequestFor($this->apiPointUrlStatus , [
            'api_key'=>env('accept_api_key')
        ]);
    }

    public function createOrder(array $data , $token)
    {
        $this->apiToken = $token ;

        return $this->sendApiRequestFor("https://accept.paymob.com/api/ecommerce/orders" , $data);
    }

    public function createInvoice(array $data , $token)
    {
        $this->apiToken = $token ;

        return $this->sendApiRequestFor('https://accept.paymobsolutions.com/api/ecommerce/orders',$data);
    }

    public function getOrderStatus(int $orderId , string $token):bool
    {
        $this->apiToken = $token ;

        $response = $this->sendApiRequestFor('https://accept.paymobsolutions.com/api/ecommerce/orders/transaction_inquiry' , [
            'auth_token'=>$token ,
            'order_id'=>$orderId,

        ]);

        if($response && isset($response->success) && $response->success )
        {
            return true ;
        }

        return false;

    }



    public function sendApiRequestFor($pointUrl , $data)
    {
        // use with curl for sending api request from php


        $curl = curl_init($pointUrl);
        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST  => $this->requestType,
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_HTTPHEADER     => array($this->apiToken, 'Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $response = curl_exec($curl);
        $curlErr  = curl_error($curl);
        curl_close($curl);
        if ($curlErr) {
            die("Curl Error: $curlErr");
        }
        return json_decode($response);
    }
    public function handleError($response) {


        $json = json_decode($response);
        if (isset($json->IsSuccess) && $json->IsSuccess == true) {
            return null;
        }

        //Check for the errors
        if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
            $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
            $blogDatas = array_column($errorsObj, 'Error', 'Name');

            $error = implode(', ', array_map(function ($k, $v) {
                return "$k: $v";
            }, array_keys($blogDatas), array_values($blogDatas)));
        } else if (isset($json->Data->ErrorMessage)) {
            $error = $json->Data->ErrorMessage;
        }

        if (empty($error)) {
            $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
        }

        return $error;
    }
    public static function getPaymentIntegrations()
    {
        if(env('APP_ENV') != 'local')
        {
            return [
                4211634
            ];
      
        }


        return [4211634];
    }
    public static function getPaymentIntegration()
    {
        if(env('APP_ENV') != 'local')
        {
            return 4211634  ;
        }

        return 4211634;
    }
    public static function getPaymentFrame($paymentToken)
    {
		// 788182
		// 788181 // to show currency for user
		return "https://accept.paymob.com/api/acceptance/iframes/788182?payment_token=$paymentToken";
        // if(env('APP_ENV') != 'local')
        // {
        // }
        // return "https://accept.paymob.com/api/acceptance/iframes/335588?payment_token=$paymentToken";

    }
	public function sendRefundOrder(int $orderId , string $token):bool
    {
        $this->apiToken = $token ;

        $response = $this->sendApiRequestFor('https://accept.paymob.com/api/acceptance/void_refund/refund' , [
            'auth_token'=>$token ,
            'transaction_id'=>$orderId,
			// "amount_cents"=>200000
        ]);
	
        if($response && isset($response->success) && $response->success )
        {
            return true ;
        }

        return false;

    }

}
