<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\QuestionOption
 *
 * @property int $id
 * @property int $question_id
 * @property string $option
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionOption extends Model
{

    protected $fillable = ['option_text', 'option_img'];

    protected static function boot() {
        parent::boot();
        self::creating(function($model) {
            if(is_null(request('is_correct'))) {
                $model->is_correct = 0;
            }
        });
        self::updating(function($model) {
            if(is_null(request('is_correct'))) {
                $model->is_correct = 0;
            }
        });
    }

}
