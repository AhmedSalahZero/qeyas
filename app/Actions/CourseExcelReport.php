<?php

namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class CourseExcelReport extends AbstractAction
{

    public function getTitle() {
        return 'التقرير';
    }

    public function getIcon() {
        return 'voyager-book';
    }

    public function getPolicy() {
        return 'edit';
    }
	
    public function getDefaultRoute() {
		return route('courses.report', $this->data->{$this->data->getKeyName()});
    }
	
    public function shouldActionDisplayOnDataType() {
		// dd( );
        return $this->dataType->slug == 'courses' && auth()->user()->is_admin();
    }

    public function getAttributes() {
        return ['class' => 'btn btn-primary  btn-sm pull-right course-report-btn ' , 'data-id'=>$this->data->{$this->data->getKeyName()} , 'data-file-name'=>$this->data->getName()];
    }


}
