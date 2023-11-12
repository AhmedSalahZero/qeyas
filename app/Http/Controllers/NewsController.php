<?php

namespace App\Http\Controllers;

use App\Mail\SendNewsMail;
use App\News;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use TCG\Voyager\Traits\AlertsMessages;

class NewsController extends Controller
{
	use AlertsMessages;
    public function index() {
        $title = 'أخبارنا';
        $news = News::where('active', 1)->paginate(10);
        return view('news.index', compact('news', 'title'));
    }

    public function show(News $news) {
        $title = $news->title;
        $news->num_watches +=1 ;
        $news->save();
        return view('news.show', compact('news', 'title'));
    }
	
	public function send(News $news){
		$users = User::where('role_id',2)->where('email','!=',null)->take(1)->get() ;
		foreach($users as $user){
			$email = $user->getEmail() ;
			if($email){
				// $message = 'asalahdev5@gmail.com';
				dispatch(function() use ($email , $news) {
					try{
						Mail::to($email)->send(new SendNewsMail($news));
					}
					catch(\Exception $e){
						
					}
				});
			}
		}
		return back()->with($this->alertSuccess('تم الارسال بنجاح'));
		
	}
}
