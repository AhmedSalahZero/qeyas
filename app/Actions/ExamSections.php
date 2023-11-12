<?php

namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class ExamSections extends AbstractAction
{

    public function getTitle() {
        return 'اقسام الاختبار';
    }

    public function getIcon() {
        return 'voyager-eye';
    }

    public function getPolicy() {
        return 'browse';
    }

    public function getDefaultRoute() {
        return route('admin.exam_sections.show', $this->data->{$this->data->getKeyName()});
    }

    public function shouldActionDisplayOnDataType() {
        return $this->dataType->slug == 'exams';
    }

    public function getAttributes() {
        return ['class' => 'btn btn-dark btn-sm pull-right'];
    }


}
