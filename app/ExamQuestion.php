<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
	
    public function options() {
        return $this->hasMany(QuestionOption::class, 'question_id', 'id');
    }

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    public function right_answer() {
        return $this->hasOne(QuestionOption::class, 'id', 'right_answer_id');
    }
}
