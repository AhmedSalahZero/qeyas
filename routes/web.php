<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\News;
use Illuminate\Http\Request;

Auth::routes();
//======================================//
//========= Social Login Routes ========//
//======================================//
Route::get('auth/{social}', 'SocialLoginController@redirectToProvider')->name('social_login');
Route::get('auth/{social}/callback', 'SocialLoginController@handleProviderCallback');


Route::get('artisan', function() {
    Artisan::call('route:list');
    dd(Artisan::output());
});
Route::group(['prefix' => 'admin'], function() {
    Voyager::routes();

    //======================================//
    //==== Exam Question & Answers Routes ===//
    //======================================//
    Route::prefix('exam_questions')->name('admin.exam_questions.')->middleware('admin.user')->group(function() {
        Route::get('{exam}/show', 'ExamQuestionsController@show')->name('show');
        // Route::get('{exam}/active', 'ExamQuestionsController@active')->name('show');
        Route::delete('{question}/delete', 'ExamQuestionsController@delete')->name('delete');
        Route::get('{question}/edit', 'ExamQuestionsController@edit')->name('edit');
        Route::put('{question}', 'ExamQuestionsController@update')->name('update');
        Route::delete('{answer}', 'ExamQuestionsController@destroy_answer')->name('delete_answer');
        Route::post('store', 'ExamQuestionsController@store')->name('store');
	Route::get('{exam}/create', 'ExamQuestionsController@create')->name('create');
        Route::post('remove', 'ExamQuestionsController@remove')->name('remove_img');
    });


    //======================================//
    //======= Exam Sections Routes =========//
    //======================================//
    Route::prefix('exam_sections')->name('admin.exam_sections.')->middleware('admin.user')->group(function() {
        Route::get('{exam}/show', 'ExamSectionsController@show')->name('show');
        Route::get('{section}/edit', 'ExamSectionsController@edit')->name('edit');
        Route::get('{exam}/create', 'ExamSectionsController@create')->name('create');
        Route::post('{exam}', 'ExamSectionsController@store')->name('store');
        Route::put('{section}', 'ExamSectionsController@update')->name('update');
        Route::delete('{section}', 'ExamSectionsController@destroy')->name('delete');
    });
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('about-us', 'HomeController@about')->name('about');
Route::get('money-back', 'HomeController@moneyBack')->name('money.back');
Route::get('contact', 'HomeController@show_contact')->name('contact');
Route::post('contact', 'HomeController@contact');
Route::get('pages/{page}', 'HomeController@pages')->name('pages');

//======================================//
//========= Qeyas News Routes ==========//
//======================================//
Route::prefix('news')->name('news.')->group(function() {
    Route::get('/', 'NewsController@index')->name('index');
    Route::get('{news}/show', 'NewsController@show')->name('show');
	Route::get('{news}/send','NewsController@send')->name('send');
});


//======================================//
//========= Categories Routes ==========//
//======================================//
Route::prefix('categories')->name('categories.')->group(function() {
    Route::get('/', 'CategoriesController@index')->name('index');
    Route::get('{category}/show', 'CategoriesController@show')->name('show');
});

//======================================//
//============ Exam Routes =============//
//======================================//
Route::prefix('exams')->name('exams.')->group(function() {
    Route::get('/', 'ExamsController@index')->name('index');
    Route::get('{exam}/toplist', 'ExamsController@toplist')->name('toplist');
    Route::get('{exam}/active', 'ExamsController@active')->name('active');
    Route::get('search', 'ExamsController@search')->name('search');
	Route::post('get_exam','ExamController@get_exam');
    Route::middleware('auth')->group(function(){
		Route::get('{exam}/show', 'ExamsController@show')->name('show');
        Route::get('{exam}/start', 'ExamsController@start')->name('start');
        Route::get('{exam}/buy', 'ExamsController@buy')->name('buy');
        Route::post('cache-old-answers','ExamsController@cacheOldAnswers')->name('cache.old.answers');
        Route::post('finish', 'ExamsController@post_exam')->name('post_exam');
        Route::get('{report}/report', 'ExamsController@report')->name('report');
        Route::get('/paypal/checkout', 'PayPalController@checkout_exam')
		->name('checkout');
        Route::get('/paypal/checkout/success', 'PayPalController@checkout_exam_success')
		->name('checkout_success');
    });
	
});

//======================================//
//============ User Routes =============//
//======================================//
Route::prefix('user')->name('user.')->middleware('auth')->group(function() {
	Route::get('profile', 'UserController@profile')->name('profile');
    Route::get('profile/edit', 'UserController@edit')->name('edit-profile');
    Route::post('profile', 'UserController@update')->name('update-profile');
    Route::post('update_password', 'UserController@update_password')->name('update_password');
    Route::get('notifications', 'UserController@notifications')->name('notifications');
});

//======================================//
//=========== Courses Routes ===========//
//======================================//
Route::prefix('courses')->name('courses.')->group(function() {
	Route::get('/', 'CoursesController@index')->name('index');
	
    Route::get('/{course}/show', 'CoursesController@show')->name('show');
	Route::get('{course}/exportStudents','CourseController@report')->name('export.students.users');
    Route::get('/{course}/active', 'CoursesController@active')->name('active');
    Route::get('/{course}/report', 'CoursesController@report')->name('report');
    Route::get('search', 'CoursesController@search')->name('search');
    Route::post('{course}/request', 'CoursesController@request')
	->middleware('auth')
	->name('request');
});

//======================================//
//=========== Books Routes ===========//
//======================================//
Route::prefix('books')->name('books.')->group(function() {
	Route::get('/', 'BooksController@index')->name('index');
    Route::get('{book}/show', 'BooksController@show')->name('show');
    Route::get('{book}/active', 'BooksController@active')->name('active');
    Route::middleware('auth')->group(function() {
		Route::get('{book}/view', 'BooksController@view')->name('view');
        Route::get('{book}/download', 'BooksController@download')->name('download');
        Route::post('{book}/buy', 'BooksController@buy')->name('buy');
        Route::get('paypal/checkout', 'PayPalController@checkout_book')
		->name('checkout');
        Route::get('paypal/checkout/success', 'PayPalController@checkout_book_success')
		->name('checkout_success');
    });
});

//======================================//
//=========== Videos Routes ===========//
//======================================//
Route::prefix('videos')->name('videos.')->group(function() {
	Route::get('/', 'VideosController@index')->name('index');
    Route::get('{video}/show', 'VideosController@show')->name('show');
});
Route::get('eeee',function(){
	return view('mails.news',[
		'new'=>News::find(2)
	]);
});

Route::get('payments/{invoiceId}','ExamsController@showPaymentPage')->name('payment.pay');

Route::get('success-payment','PayPalController@successCallback');
Route::get('test-refund/{payment_id}','PaypalController@sendRefundOrder')->name('refund.request');
// ajax
Route::get('course-report/{course}','CoursesController@report');
