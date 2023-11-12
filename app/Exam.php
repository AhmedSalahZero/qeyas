<?php

namespace App;

use App\Traits\HasCreatedByAndUpdatedBy;
use App\Traits\HasPurchaseCount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Exam
 *
 * @property int $id
 * @property string $title
 * @property int $course_id
 * @property int $category_id
 * @property int $available
 * @property string $exam_type
 * @property string $exam_price
 * @property string $exam_duration
 * @property string|null $icon_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereExamDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereExamPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereExamType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereIconUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Exam extends Model
{


	use HasCreatedByAndUpdatedBy , HasPurchaseCount ;
	
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

    protected static function boot() {
        parent::boot();
		
		
        static::addGlobalScope('allowed',function($builder){
			if(auth()->user() && !auth()->user()->is_admin() && in_array('admin',request()->segments())){
				$builder->where('created_by',auth()->user()->id);
			}
		});
		
        self::creating(function($model){
			$model->created_by = auth()->user()->id  ;
            if(is_null(request('exam_price')) || request('exam_type') === 'free'){
				$model->exam_price = 0;
            }
			if(!auth()->user()->is_admin()){
				$model->available = 0 ;
			}
        });
        self::updating(function($model){
			$model->updated_by = auth()->user()->id  ;
            if(is_null(request('exam_price')) || request('exam_type') === 'free'){
                $model->exam_price = 0;
            }
			if(!auth()->user()->is_admin()){
					$model->available = 0 ;
			}
        });
    }


    public function is_purchased($exam_id,$user_id)
    {
        return boolval(ExamRequest::where('exam_id', $exam_id)->where('user_id', $user_id)->where('status','approved')->first());
    }


    public static function highest_attempt($exam_id,$user_id)
    {
        $attempt = ExamTry::where('user_id', $user_id)->orderBy('percentage','desc')->select('exam_id','result','time_spent','created_at')->first();
        $attempt['count'] = ExamTry::where('user_id',$user_id)->where('exam_id',$exam_id)->count();

        return $attempt;
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function questions() {
        return $this->hasMany(ExamQuestion::class);
    }

    public function sections() {
        return $this->hasMany(ExamSection::class);
    }

    public function is_paid() {
        return $this->exam_type == "paid";
    }

    public function user_payment() {
        return $this->hasOne(Payment::class)->where('user_id', \Auth::id() ?? 0);
    }

    public function getPaymentDateAttribute() {
        $date = $this->user_payment->created_at;
        return "$date->day " . $this->ar_month[$date->shortEnglishMonth] . " $date->year";
    }
	
	public function getPaymentStatusAttribute() {
        $payment = $this->user_payment;
		
		return $payment->getStatusInAr();
    }

    public function reports() {
        return $this->hasMany(ExamReport::class);
    }
	public function scopeOnlyFor($query){
		return $query;
		return Auth()->user()->is_admin() ? $query : $query->where('created_by', auth()->user()->id);
	}
	
	public function payments()
	{
		return $this->hasMany(Payment::class , 'exam_id','id');
	}
	public function getInstructions()
	{
		return $this->instructions ?: setting('site.preexam_info') ;
	}
	
	public function getTitle()
	{
		return $this->title ;
	}
	public function getName()
	{
		return $this->getTitle();
	}
	public function getPrice()
	{
		return $this->exam_price ;
	}
	public function isEnglish()
	{
		return $this->lang =='en';
	}
	
//
//    public function getExamDurationAttribute($value)
//    {
//        dd(date('H:i:s',mktime($value)));
//    }
}
