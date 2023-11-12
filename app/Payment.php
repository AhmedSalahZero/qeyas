<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Payment
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $admin_id
 * @property int $price
 * @property int|null $book_id
 * @property int|null $exam_id
 * @property string $payment_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereUserId($value)
 * @mixin \Eloquent
 */
class Payment extends Model
{
	protected $guarded =['id'];
    // protected $fillable = ['status', 'token', 'invoice_id', 'user_id', 'exam_id', 'book_id', 'admin_id', 'price','order_id','course_id'];

    protected static function boot() {
        parent::boot();
		
		
        self::creating(function($model){
            $model->admin_id = Auth::id() ?? null;
        });
		
		
		
		static::addGlobalScope('allowed',function($builder){
			if(auth()->user() && !auth()->user()->is_admin() && in_array('admin',request()->segments())){
				$builder->where(function($builder){
					$builder->whereHas('exam',function($builder){
						$builder->where('created_by',auth()->user()->id);
					})
					->orWhereHas('book',function($builder){
						$builder->where('created_by',auth()->user()->id);
					})
					->orWhere('admin_id',auth()->user()->id)
					;
					
				});
			}
		
			
		});
		
		
    }


    public function exam()
    {
        return $this->belongsTo(Exam::class,'exam_id');
    }
	public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
	public function book()
	{
		return $this->belongsTo(Book::class ,'book_id','id');
	}
	public  function getProductFromPayment() 
	{
		$product = null ;
		// dd($this);
		if($this->exam_id){
			$product = Exam::find($this->exam_id);
		}
		elseif($this->book_id){
			$product = Book::find($this->book_id);
		}
		elseif($this->course_id){
			$product = Course::find($this->course_id);
		}
		return $product ; 
		
	}
	public function getPrice()
	{
		return $this->price ;
	}
	public function getPaymentToken()
	{
		return $this->token ;
	}
	public function user()
	{
		return $this->belongsTo(User::class , 'user_id','id');
	}
	public function getStatusInAr()
	{
		return $this->status == 'approved' ? 'تم الدفع':'لم يتم الدفع بعد';
	}

	public function getTransActionId()
	{
		return $this->transaction_id;
	}
	public function canBeRefunded()
	{
		return true ;
	}
	
}
