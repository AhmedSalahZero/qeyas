<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

/**
 * App\ExamTry
 *
 * @property int $id
 * @property int $exam_id
 * @property int $user_id
 * @property string $result
 * @property string $time_spent
 * @property string $try_date
 * @property int $num_passed_questions
 * @property int $num_failed_questions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry whereNumFailedQuestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry whereNumPassedQuestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry whereTimeSpent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry whereTryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamTry whereUserId($value)
 * @mixin \Eloquent
 */
class ExamTry extends Model
{
    protected $table = 'exam_tries';
    protected $fillable =
        [
            'user_id','exam_id','result','time_spent','num_passed_questions','num_failed_questions','percentage'
        ];


    public function get_user($user_id)
    {
        $user = User::where('id', $user_id)->select('name','avatar as avatar_api','city','education_level')->first();
        $user['city_name'] = $user->city != '' ? City::where('id', $user->city)->first()->city_name : '';
        $user['education_name'] = $user->education_level != '' ? Education::where('id', $user->education_level)->first()->name : '';

        unset($user->city,$user->education_level);

        return $user;
    }


    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->toDateTimeString();
    }

    public function failed_questions() {
        return $this->hasMany(UserAnswer::class)->whereRaw('answer_id != right_answer_id');
    }
}
