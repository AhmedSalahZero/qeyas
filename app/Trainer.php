<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Trainer
 *
 * @property int $id
 * @property string $trainer_name
 * @property int $course_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trainer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trainer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trainer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trainer whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trainer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trainer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trainer whereTrainerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trainer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Trainer extends Model
{
    public function courses() {
        return $this->belongsToMany(Course::class, 'course_trainer');
    }
}
