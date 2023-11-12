<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $table = 'user_answers';

    public function question() {
        return $this->belongsTo(ExamQuestion::class);
    }

    public function answer() {
        return $this->belongsTo(QuestionOption::class, 'answer_id', 'id');
    }

    public function right_answer() {
        return $this->belongsTo(QuestionOption::class, 'right_answer_id', 'id');
    }
}
