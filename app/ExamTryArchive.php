<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamTryArchive extends Model
{
    protected $table = 'exam_try_archives';


    protected $fillable =
        [
            'try_id','question_id','answer_id','right_answer_id'
        ];


    public function get_question($id)
    {
        return Question::where('id',$id)->select('question_text as question','section_id','question_img as image_api','paragraph','explanation')->first();
    }


    public function get_section($section_id)
    {
        $section = ExamSection::find($section_id);
        return $section->section_title;
    }


    public function get_answers($id)
    {
        $answers = Answer::where('question_id', $id)->select('id','option_text as text','option_img as image_api')->get();

        foreach($answers as $answer)
        {
            $a_no_tags = strip_tags($answer->text,'<p>');
            $answer['a_html'] = ($answer->text != $a_no_tags) ? true : false ;
        }

        return $answers;
    }
}
