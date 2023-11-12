<?php 
namespace App\Services ;
class MoneyConverter {
	public function convert(float $amount , $from = 'SAR' , $to = 'EGP'  ):?float 
	{
	
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.exchangerate.host/convert?from=".$from."&to=".$to."&amount=".$amount."&access_key=".$this->getAccessToken(),
			CURLOPT_RETURNTRANSFER => 1
		));
		$response = curl_exec($curl);
		$response = (array)json_decode($response) ;
		return isset($response['success']) &&  $response['success']  ? $response['result'] : null   ;
	}
	protected function getAccessToken()
	{
		return 'c0447f3a3b91c78532fbb1b5ac6bae51';
		// for production (qeyas)
		// return 'c0447f3a3b91c78532fbb1b5ac6bae51';
		// for my free account
		//return '50148de0c47f98bae29c29623dac4957';
	}
}
