<?php

namespace App\Widgets;

use App\Exam;
use Illuminate\Support\Str;
use TCG\Voyager\Widgets\BaseDimmer;

class Exams extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
	
	public $additional_attributes  = ['payment_count'];
	public function getPaymentCountBrowseAttribute(){
		return 4 ;
	}
	
	public function getPaymentCountAttribute(){
		return 4 ;
	}

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Exam::count();
        $string = trans_choice('voyager::dimmer.exam', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-file-text',
            'title'  => "{$count} {$string}",
            'text'   => '',
            'button' => [
                'text' => __('voyager::dimmer.page_link_text'),
                'link' => route('voyager.exams.index'),
            ],
            'image' => asset('images/20190327091907.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return app('VoyagerAuth')->user()->can('browse', new Exam)  ;
    }

	
}
