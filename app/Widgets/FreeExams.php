<?php

namespace App\Widgets;

use Illuminate\Support\Str;
use TCG\Voyager\Widgets\BaseDimmer;
use App\Exam;

class FreeExams extends BaseDimmer
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
        $count = Exam::where('exam_type', 'free')->count();
        $string = trans_choice('voyager::dimmer.free_exam', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-file-text',
            'title'  => "{$count} {$string}",
            'text' => '',
            'button' => ['text' => '', 'link' => '', 'hide' => true],
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
