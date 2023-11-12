<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamSection extends Model
{
    protected $fillable = [
        'section_title',
        'section_order',
        'status'
    ];

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    public function questions() {
        return $this->hasMany(ExamQuestion::class, 'section_id');
    }
}
