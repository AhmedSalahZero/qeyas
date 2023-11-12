<?php

namespace App;

use App\Traits\HasCreatedByAndUpdatedBy;

use App\Traits\HasPurchaseCount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
	
	use HasCreatedByAndUpdatedBy , HasPurchaseCount ;
	
	public static function boot()
	{
		parent::boot();
		static::addGlobalScope('allowed',function($builder){
			if(auth()->user() && !auth()->user()->is_admin() && in_array('admin',request()->segments())){
				$builder->where('created_by',auth()->user()->id);
			}
			if(!in_array('admin',Request()->segments())){
				$builder->where('active',1);
			}
			
		});
		
		self::creating(function($model){
			$model->created_by = auth()->user()->id  ;
			if(!auth()->user()->is_admin()){
				$model->active = 0 ;
			}
        });
		
		self::updating(function($model){
			$model->updated_by = auth()->user()->id  ;
			if(!auth()->user()->is_admin()){
					$model->active = 0 ;
			}
           
        });
	}
	
	
    private $ar_month = [
        'Jan' => 'يناير',
        'Feb' => 'فبراير',
        'Mar' => 'مارس',
        'Apr' => 'أبريل',
        'May' => 'مايو',
        'Jun' => 'يونيو',
        'Jul' => 'يوليو',
        'Aug' => 'أغسطس',
        'Sep' => 'سبتمبر',
        'Oct' => 'أكتوبر',
        'Nov' => 'نوفمبر',
        'Dec' => 'ديسمبر',
    ];

    public function getReleaseDateAttribute() {
        $value = Carbon::parse($this->book_release_date);
        return "$value->day " . $this->ar_month[$value->shortEnglishMonth] . " $value->year";
    }

    public function getUrlAttribute() {
        return json_decode($this->book_url)[0]->download_link;
    }

    public function user_payment() {
        return $this->hasOne(Payment::class)->where('user_id', \Auth::id() ?? 0);
    }

    public function getPaymentDateAttribute() {
        $date = $this->user_payment->created_at;
        return "$date->day " . $this->ar_month[$date->shortEnglishMonth] . " $date->year";
    }
	public function getPaymentPriceAttribute() {
        $payment = $this->user_payment;
		// return $payment->id;
		// dd($payment);
		return $payment->price ;
    }
	
	public function payments()
	{
		return $this->hasMany(Payment::class , 'book_id','id');
	}
	public function getPrice()
	{
		return $this->book_price;
	}
	public function getName()
	{
		return $this->getTitle();
	}	
	public function getTitle()
	{
		return $this->book_title;
	}
	public function isFree()
	{
		return $this->book_price == 0 ;
	}
	
	public function requests()
	{
		return $this->hasMany(BookRequest::class , 'book_id','id');
	}
}
