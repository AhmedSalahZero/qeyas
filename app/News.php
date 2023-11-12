<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\News
 *
 * @property int $id
 * @property string $title
 * @property string $photo
 * @property string $content
 * @property string $news_date
 * @property string $num_watches
 * @property string $likes
 * @property string $dislikes
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereDislikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereNewsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereNumWatches($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class News extends Model
{
    protected $table = 'qeyas_news';

    protected $dates = ['news_date'];


    public function getMinContentAttribute($value)
    {
        return str_limit($value,200);
    }


    public function getPhotoApiAttribute($value)
    {
        return $_SERVER['APP_URL'].'/storage/'.$value;
    }


    public function getNewsDateApiAttribute($value)
    {
        return Carbon::parse($value)->toDateString();
    }
	public function getTitle()
	{
		return $this->title;
	}
	public function getDescription()
	{
		return $this->content;
	}
	public function getImage()
	{
		return asset('storage/'.$this->photo);
	}
}
