<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Question
 *
 * @property int $id
 * @property int $exam_id
 * @property string $question
 * @property int|null $right_answer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereRightAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    protected $table = 'exam_questions';


    public function getImageApiAttribute($value)
    {
        if($value != NULL) return $_SERVER['APP_URL'].'/storage/'.$value;
        else return '';
    }


    public function getParagraphAttribute($value)
    {
        if($value != NULL) return $value;
        else return '';
    }


    public function getExplanationAttribute($value)
    {
        if($value != NULL) return $value;
        else return '';
    }


    public function get_section($section_id)
    {
        $section = ExamSection::find($section_id);
        return $section->section_title;
    }


    public function get_answers($question_id)
    {
        $answers = Answer::where('question_id', $question_id)->select('id','option_text as text','option_img as image_api')->get();

        foreach($answers as $answer)
        {
            $a_no_tags = strip_tags($answer->text,'<p>');
            $answer['a_html'] = ($answer->text != $a_no_tags) ? true : false ;
        }

        return $answers;
    }
}
