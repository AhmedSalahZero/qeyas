<?php 
namespace App\Traits;

use App\Payment;

trait HasPurchaseCount 
{

	public function getPurchaseCountReadAttribute()
	{
		return $this->payments->where('status','approved')->count() ;
	}
	public function getTotalMoneyReadAttribute()
	{
		$totalSum = $this->payments->where('status','approved')->sum('price') ;
		if($totalSum == 0){
			return 0 ;
		}
		return number_format($totalSum,2) . ' ' . getMainCurrency() ;
	}
	
}
