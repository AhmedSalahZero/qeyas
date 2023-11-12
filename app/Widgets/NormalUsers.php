<?php

namespace App\Widgets;

use App\User;
use Illuminate\Support\Str;
use TCG\Voyager\Widgets\BaseDimmer;

class NormalUsers extends BaseDimmer
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
        $count = User::where('role_id', 2)->count();
        $string = trans_choice('voyager::dimmer.normal_user', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-file-text',
            'title'  => "{$count} {$string}",
            'text'   => '',
            'button' => [
                'text' => __('voyager::dimmer.user_link_text'),
                'link' => route('voyager.users.index', ['key' => 'role_id', 'filter' => 'equals', 's' => 2]),
            ],
            'image' => asset('images/20190327091907.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed(){
		return auth()->user()->is_admin();
	 }
}
