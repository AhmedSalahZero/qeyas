<?php

namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class ActiveExam extends AbstractAction
{

    public function getTitle() {
        return 'تفعيل';
    }

    public function getIcon() {
        return 'voyager-eye';
    }

    public function getPolicy() {
        return 'edit';
    }
	
    public function getDefaultRoute() {
		return route('exams.active', $this->data->{$this->data->getKeyName()});
    }
	
    public function shouldActionDisplayOnDataType() {
		// dd( );
        return $this->dataType->slug == 'exams' && auth()->user()->is_admin() && !$this->data->available ;
    }

    public function getAttributes() {
        return ['class' => 'btn btn-primary  btn-sm pull-right'];
    }


}
