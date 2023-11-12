<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Adsense
 *
 * @property int $id
 * @property string $ad_name
 * @property string $ad_photo
 * @property string $ad_url
 * @property string $show
 * @property string $ad_end_date
 * @property int $active
 * @property int $num_views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense whereAdEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense whereAdName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense whereAdPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense whereAdUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense whereNumViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense whereShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Adsense whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Adsense extends Model
{
    protected $table = 'adsense';


    public function getAdPhotoApiAttribute($value)
    {
        return $_SERVER['APP_URL'].'/storage/'.$value;
    }
}
