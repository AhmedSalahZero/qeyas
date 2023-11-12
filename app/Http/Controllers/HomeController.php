<?php

namespace App\Http\Controllers;

use App\Book;
use App\ContactUs;
use App\Course;
use App\News;
use App\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index() {
        $title = 'الرئيسية';
        $courses = Course::latest()->take(3)->get();
        $books = Book::latest()->take(3)->get();
        $news = News::select('id','title','news_date')->get();

        return view('index', compact('title', 'courses', 'books', 'news'));
    }

    public function about() {
        $title = 'عن قياس 2030';
        return view('about', compact('title'));
    }

    public function show_contact() {
        $title = 'مراسلة الادارة';
        return view('contact', compact('title'));
    }

    public function contact(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'required',
            'subject' => 'required|in:complaint,suggestion,other',
            'message' => 'required|string'
        ]);

        ContactUs::create($request->all());

        return back()->with('message', 'تم الارسال بنجاح');
    }

    public function pages(Page $page) {
        $title = $page->title;
        return view('pages', compact('page', 'title'));
    }
	public function moneyBack(Request $request){
		return view('money-back');
	}
}
