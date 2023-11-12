<?php

namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class SendNewsEmail extends AbstractAction
{

    public function getTitle() {
        return 'ارسال عبر البريد';
    }

    public function getIcon() {
        return 'voyager-eye';
    }

    public function getPolicy() {
        return 'edit';
    }

    public function getDefaultRoute() {
        return route('news.send', $this->data->{$this->data->getKeyName()});
    }

    public function shouldActionDisplayOnDataType() {
        return $this->dataType->slug == 'qeyas-news';
    }

    public function getAttributes() {
        return ['class' => 'btn btn-success btn-sm pull-right'];
    }


}
