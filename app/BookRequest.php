<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
	protected $guarded =['id'];
    // protected $fillable = [
    //     'user_id', 'book_id', 'status'
    // ];

    protected $table = 'book_requests';
	
	public function book()
	{
		return $this->belongsTo(Book::class ,'book_id','id');
	}
	
	public function getPaymentStatusInAr(){
		return getPaymentStatusInArr($this->status);
	}
	
	protected static function boot() {
        parent::boot();
		
		
        static::addGlobalScope('allowed',function($builder){
			if(auth()->user() && !auth()->user()->is_admin() && in_array('admin',request()->segments())){
				$builder->whereHas('book',function($q){
					$q->where('created_by',auth()->user()->id );
				});
			}
		});
		
        // self::creating(function($model){
		// 	$model->created_by = auth()->user()->id  ;
        //     if(is_null(request('exam_price')) || request('exam_type') === 'free'){
		// 		$model->exam_price = 0;
        //     }
		// 	if(!auth()->user()->is_admin()){
		// 		$model->available = 0 ;
		// 	}
        // });
        // self::updating(function($model){
		// 	$model->updated_by = auth()->user()->id  ;
        //     if(is_null(request('exam_price')) || request('exam_type') === 'free'){
        //         $model->exam_price = 0;
        //     }
		// 	if(!auth()->user()->is_admin()){
		// 			$model->available = 0 ;
		// 	}
        // });
    }
	
	public function payment()
	{
	  return $this->belongsTo(Payment::class , 'payment_id','id');
	}
	
	public function getStatusInAr()
  {
	return getPaymentStatusInArr($this->status);
  }
  public function is_paid()
  {
	return !$this->is_free;
  }

  public function user()
  {
	return $this->belongsTo(User::class , 'user_id','id');
  }
}
