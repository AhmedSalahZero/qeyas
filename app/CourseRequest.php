<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRequest extends Model
{
    protected $table = 'course_requests';
    protected $guarded = ['id'];
	
	public function getStatusBrowseAttribute()
	{
		if($this->is_free){
			return 'مجاني';
		}
		if($this->status == 'approved'){
			return 'مؤكد';
		}
		return 'قيد المراجعة ';
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
  public function course()
  {
	return $this->belongsTo(Course::class , 'course_id','id');
  }
  public function user()
  {
	return $this->belongsTo(User::class , 'user_id','id');
  }
  public function getPaymentStatusInAr(){
	return getPaymentStatusInArr($this->status);
}
public function getPrice()
{
	if($this->is_free){
		return 0 ;
	}
	return $this->price ;
	
	// if($this->)
	// return $this->is_free ? 0 : 
}
}
