<?php

namespace App\Widgets;

use App\Payment;
use Illuminate\Support\Str;
use TCG\Voyager\Widgets\BaseDimmer;

class TotalPaymentsExams extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Payment::whereNotNull('exam_id')->sum('price');
        $string = trans_choice('voyager::dimmer.total_payment_exams', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-file-text',
            'title'  => "{$count} {$string}",
            'text'   => '',
            'button' => [
                'text' => __('voyager::dimmer.page_link_text'),
                'link' => route('voyager.payments.index'),
                'hide' => ''
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
        return true;
    }
}
