<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ExamRequest
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamRequest query()
 * @mixin \Eloquent
 */
class ExamRequest extends Model
{
  protected $guarded = ['id'];
  public function payment()
  {
	return $this->belongsTo(Payment::class , 'payment_id','id');
  }
  public function exam()
  {
	return $this->belongsTo(Exam::class , 'exam_id','id');
  }
  public function user()
  {
	return $this->belongsTo(User::class , 'user_id','id');
  }
  
  
  public function getStatusInAr()
  {
	return getPaymentStatusInArr($this->status);
  }
  public function is_paid()
  {
	return !$this->is_free;
  }
  public function getPrice()
  {
	if($this->is_paid()){
		return $this->payment ? $this->payment->getPrice() : $this->exam->getPrice(); 
	}
	return 0;
  }
}
