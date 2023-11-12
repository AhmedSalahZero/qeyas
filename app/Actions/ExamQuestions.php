<?php

namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class ExamQuestions extends AbstractAction
{

    public function getTitle() {
        return 'اسئلة الاختبار';
    }

    public function getIcon() {
        return 'voyager-eye';
    }

    public function getPolicy() {
        return 'browse';
    }

    public function getDefaultRoute() {
        return route('admin.exam_questions.show', $this->data->{$this->data->getKeyName()});
    }

    public function shouldActionDisplayOnDataType() {
        return $this->dataType->slug == 'exams';
    }

    public function getAttributes() {
        return ['class' => 'btn btn-success btn-sm pull-right'];
    }


}
