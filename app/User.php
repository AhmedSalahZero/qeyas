<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\User
 *
 * @property int $id
 * @property int|null $role_id
 * @property string $name
 * @property string|null $picture
 * @property string|null $phone
 * @property string|null $gender
 * @property string|null $education_level
 * @property int|null $city_id
 * @property string $email
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $city
 * @property mixed $locale
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \TCG\Voyager\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEducationLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends \TCG\Voyager\Models\User
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'password', 'gender', 'city', 'education_level', 'code', 'code_expire', 'avatar', 'platform', 'social_id', 'email','has_refunded'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getPhoneAttribute($value) {
        return $value == null ? '' : $value;
    }
	

    public function getCityAttribute($value) {
        return $value == null ? '' : $value;
    }


    public function getEducationLevelAttribute($value)
    {
        return $value == null ? '' : $value;
    }

    public function payments() {
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }

    public function is_admin() {
        return (\Auth::user()->role_id === 1 || \Auth::user()->role_id === 3);
    }

    public function has_exam(int $exam_id) {
		return $this->examRequests->where('exam_id',$exam_id)->where('status','approved')->count();
		// 
		// return $this->payments->where('exam_id',$exam_id)->where('status','approved')->count() ;
    }

    public function has_book(int $book_id) {
		return $this->bookRequests->where('book_id',$book_id)->where('status','approved')->count();
        // return $this->payments()->where('book_id', $book_id)->where('status', 'approved')->exists();
    }
	public function has_course(int $course_id) {
		return $this->courseRequests->where('course_id',$course_id)->where('status','approved')->count();
        // return $this->payments()->where('course_id', $course_id)->where('status', 'approved')->exists();
    }

    public function user_city() {
        return $this->belongsTo(City::class, 'city', 'id');
    }
	
	public function examRequests()
	{
		return $this->hasMany(ExamRequest::class , 'user_id','id');
	}
	
	// not sure about it
    public function exams() {
        return $this->hasManyThrough(Exam::class, Payment::class, 'user_id', 'id', 'id', 'exam_id');
    }
	
	public function courses() {
        return $this->hasManyThrough(Course::class, Payment::class, 'user_id', 'id', 'id', 'course_id');
    }

	// not sure about it
    public function books() {
        return $this->hasManyThrough(Book::class, Payment::class, 'user_id', 'id', 'id', 'book_id')->with('user_payment');
    }
	public function bookRequests()
	{
		return $this->hasMany(BookRequest::class , 'user_id','id');
	}
	
	public function courseRequests()
	{
		return $this->hasMany(CourseRequest::class , 'user_id','id');
	}

    public function getAvatarApiAttribute($value)
    {
        $check = str_split($value,5);

        if($check[0] != 'users') return $value;
        return $_SERVER['APP_URL'].'/storage/'.$value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUserNotificationsAttribute() {
        $notifications = UserNotification::where(function($q) {
            return $q->where('type', 'public')->where(function($q) {
                return $q->where('city_id', $this->city)->orWhere('city_id', Null);
            });
        })->where(function($q) {
            return $q->where('type', 'public')->where(function($q) {
                return $q->where('user_gender', $this->gender)->orWhere('user_gender', Null);
            });
        })->where(function($q) {
            return $q->where('type', 'public')->where(function($q) {
                return $q->where('education_level', $this->education_level)->orWhere('education_level', Null);
            });
        })->orWhere(function($q) {
            return $q->where('type', 'private')->where('user_id', $this->id);
        })->latest()->get();

        return $notifications;
    }

    public function exam_reports() {
        return $this->hasMany(ExamReport::class);
    }

    public function exam_tries() {
        return $this->hasMany(ExamTry::class);
    }
	
	public function getEmail()
	{
		return $this->email ;
	}
	public function getName()
	{
		return $this->name ;
	}
	public function getPhone()
	{
		return $this->phone ;
	}
	public function hasRefundedBefore()
	{
		return $this->has_refunded ;
	}
	function canRefund($model)
{
	return $model->created_at->diffInDays() <= 2 && !$this->has_refunded ;
}
}
