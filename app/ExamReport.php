<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ExamReport
 *
 * @property int $id
 * @property int $exam_id
 * @property int $user_id
 * @property string $num_tries
 * @property string $highest_result
 * @property string $last_try_date
 * @property string $time_spent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport whereHighestResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport whereLastTryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport whereNumTries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport whereTimeSpent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExamReport whereUserId($value)
 * @mixin \Eloquent
 */
class ExamReport extends Model
{
    protected $fillable =
        [
            'user_id','exam_id','num_tries','highest_result','last_try_date','time_spent'
        ];

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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    public function getLastTryAttribute() {
        $value = Carbon::parse($this->last_try_date);
        return "$value->day " . $this->ar_month[$value->shortEnglishMonth] . " $value->year";
    }
}
