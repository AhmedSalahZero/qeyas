<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Video
 *
 * @property int $id
 * @property string $video_title
 * @property string $video_num_watches
 * @property string $video_url
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereVideoNumWatches($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereVideoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereVideoUrl($value)
 * @mixin \Eloquent
 */
class Video extends Model
{
    protected $fillable =
        [
            'video_num_watches'
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


    public function getVideoDescriptionAttribute($value)
    {
        return $value != NULL ? $value : '';
    }

    public function getDateAttribute() {
        $value = Carbon::parse($this->created_at);
        return "$value->day " . $this->ar_month[$value->shortEnglishMonth] . " $value->year";
    }

    public function getVideoIdAttribute() {
        $url = $this->video_url;
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        $id = $match[1] ?? null;
        return $id;
    }
	public function course()
	{
		return $this->belongsTo(Course::class ,'course_id','id');
	}
}
