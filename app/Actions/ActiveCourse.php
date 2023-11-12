<?php

namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class ActiveCourse extends AbstractAction
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
		return route('courses.active', $this->data->{$this->data->getKeyName()});
    }
	
    public function shouldActionDisplayOnDataType() {
		// dd( );
        return $this->dataType->slug == 'courses' && auth()->user()->is_admin() && !$this->data->active ;
    }

    public function getAttributes() {
        return ['class' => 'btn btn-primary  btn-sm pull-right'];
    }


}
