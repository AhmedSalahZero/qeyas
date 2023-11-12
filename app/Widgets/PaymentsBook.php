<?php

namespace App\Widgets;

use App\Payment;
use Illuminate\Support\Str;
use TCG\Voyager\Widgets\BaseDimmer;

class PaymentsBook extends BaseDimmer
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
        $count = Payment::whereNotNull('book_id')->count();
        $string = trans_choice('voyager::dimmer.payment_book', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-file-text',
            'title'  => "{$count} {$string}",
            'text'   => '',
            'button' => [
                'text' => '',
                'link' => '',
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
