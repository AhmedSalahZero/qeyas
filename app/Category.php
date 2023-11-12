<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @property int $cat_id
 * @property string|null $cat_name
 * @property int $cat_parent
 * @property int $cat_order
 * @property int $cat_app_order
 * @property string|null $cat_image
 * @property int $cat_author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCatAppOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCatAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCatImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCatName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCatOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCatParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    protected static function boot() {
        parent::boot();
        self::creating(function($model){
            if(is_null(request('cat_parent'))){
                $model->cat_parent = 0;
            }
            if(is_null(request('cat_author_id'))){
                $model->cat_author_id = \Auth::id();
            }
        });
        self::updating(function($model){
            if(is_null(request('cat_parent'))){
                $model->cat_parent = 0;
            }
            if(is_null(request('cat_author_id'))){
                $model->cat_author_id = \Auth::id();
            }
        });
    }

    public function exams_count($id)
    {
        $ids = [];

        $sub_cats = Category::where('cat_parent', $id)->pluck('id');

        foreach($sub_cats as $sub)
        {
            array_push($ids,$sub);
            $secondaries = Category::where('cat_parent', $sub)->pluck('id');

            foreach($secondaries as $sec)
            {
                array_push($ids,$sec);
            }
        }

        $count = Exam::whereIn('category_id',$ids)->count();

        return $count;
    }

    public function get_exams_count($id)
    {
        $count = Exam::where('category_id',$id)->count();
        return $count;
    }

    public function is_last($id)
    {
        $subs = Category::where('cat_parent', $id)->count();

        if($subs > 0) return false;
        else return true;
    }

    public function sub_categories() {
        return $this->hasMany(self::class, 'cat_parent', 'id');
    }

    public function parent_category() {
        return $this->belongsTo(self::class, 'cat_parent', 'id');
    }

    public function exams() {
        return $this->hasMany(Exam::class);
    }
	public function getExamsQuery()
	{
		return $this->exams()->where('available',1);
	}
    public function getCatImageApiAttribute($value)
    {
        return $value != NULL ? $_SERVER['APP_URL'].'/storage/'.$value : '';
    }

    public function is_parent() {
        return (bool) $this->sub_categories()->count();
    }

    public function exam_count() {
        $count = 0;
        $count += $this->exams->count();
        if($this->is_parent()){
            foreach($this->sub_categories as $sub_category) {
                $count += $sub_category->exam_count();
            }
        }
        return $count;
    }
	// public static function getMainFrom(array $mainAndSubCatego)

}
