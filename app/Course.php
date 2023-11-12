<?php

namespace App;

use App\Traits\HasCreatedByAndUpdatedBy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

/**
 * App\Course
 *
 * @property int $id
 * @property int $order
 * @property string $course_title
 * @property string $course_photo
 * @property string $start_date
 * @property string $end_date
 * @property string $hours
 * @property string $course_price
 * @property string $course_description
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCourseDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCoursePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCoursePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCourseTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Course extends Model
{
	use HasCreatedByAndUpdatedBy ;
	
	const RECORDED = 'recorded';
	const RECORDED_AR = 'مسجلة';
	const LIVE = 'live';
	const LIVE_AR = 'مباشرة';
	

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

    public function trainers() {
        return $this->belongsToMany(Trainer::class, 'course_trainer');
    }

    public function getStartAttribute() {
        $value = Carbon::parse($this->start_date);
        return "$value->day " . $this->ar_month[$value->shortEnglishMonth] . " $value->year";
    }
    public function getEndAttribute() {
        $value = Carbon::parse($this->end_date);
        return "$value->day " . $this->ar_month[$value->shortEnglishMonth] . " $value->year";
    }

    public function requests() {
        return $this->hasMany(CourseRequest::class);
    }
	
	public static function boot()
	{
		parent::boot();
		static::addGlobalScope('allowed',function($builder){
			if(auth()->user() && !auth()->user()->is_admin() && in_array('admin',request()->segments())){
				$builder->where('created_by',auth()->user()->id);
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
	public static function getCoursesTypes()
	{
		return [
			Self::RECORDED => SELF::RECORDED_AR,
			SELF::LIVE => SELF::LIVE_AR
		];
	}
	public function getType(){
		return $this->type  ? 'مباشرة' : 'مسجلة';
	}
	public function getName()
	{
		return $this->getTitle() ;
	}
	public function getTitle()
	{
		return $this->course_title;
	}

public function getGoals(){
	return $this->goals ; 
}	
public function getDebrief()
{
	return $this->debrief ;
}
public function getMainLines()
{
	return $this->main_lines ;
}
public function getIntro()
{
	return $this->intro;
}
public function getPrice()
{
	return $this->course_price ;
}
public function isFree():bool 
{
	return $this->course_price ==  0 ;
}

		public static function getVideoId($url) {
			preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
			$id = $match[1];
			return $id;
		}
		public function getVideoIdAttribute() {
			$url = $this->video_url;
			preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
			$id = $match[1];
			return $id;
		}
		public function videos(){
			return $this->hasMany(Video::class , 'course_id','id');
		}
		public function isLive()
		{
			return $this->type  ;
		}
		public function isRecorded(){
			return ! $this->type  ;
		}  
		public function getPaymentDateAttribute() {
			$date = $this->user_payment->created_at;
			return "$date->day " . $this->ar_month[$date->shortEnglishMonth] . " $date->year";
		}
		public function user_payment() {
			return $this->hasOne(Payment::class)->where('user_id', \Auth::id() ?? 0);
		}

}
