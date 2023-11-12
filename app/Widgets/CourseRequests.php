<?php

namespace App\Widgets;

use App\CourseRequest;
use Illuminate\Support\Str;
use TCG\Voyager\Widgets\BaseDimmer;

class CourseRequests extends BaseDimmer
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
        $count = CourseRequest::count();
        $string = trans_choice('voyager::dimmer.course_request', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-file-text',
            'title'  => "{$count} {$string}",
            'text'   => '',
            'button' => [
                'text' => __('voyager::dimmer.page_link_text'),
                'link' => route('voyager.course-requests.index'),
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
        return app('VoyagerAuth')->user()->can('browse', new CourseRequest);
    }
}
