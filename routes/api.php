<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'Api\AuthController@register');
Route::post('/social_login', 'Api\AuthController@social_login');
Route::post('/login', 'Api\AuthController@login');
Route::post('/token_update', 'Api\AuthController@token_update');
Route::post('/profile/update', 'Api\AuthController@update');
Route::post('/password/reset', 'Api\AuthController@password_reset');
Route::post('/password/check', 'Api\AuthController@code_check');
Route::post('/password/change', 'Api\AuthController@password_change');
Route::post('/user/exam_attempts', 'Api\AuthController@attempts');
Route::post('/user/attempt/details', 'Api\AuthController@attempt_details');

Route::get('/index', 'Api\HomeController@index');
Route::post('/slider/watch', 'Api\HomeController@slider_watch');
Route::get('/sub_cats/{id}', 'Api\HomeController@sub_cats');
Route::post('/search', 'Api\HomeController@search');

Route::get('/exams/{cat_id}/{user_id}', 'Api\ExamController@get_exams');
Route::post('/exam/get', 'Api\ExamController@get_exam');
Route::post('/exam/submit', 'Api\ExamController@submit');
Route::post('/exams/previous_attempts', 'Api\ExamController@previous_attempts');
Route::post('/exam/get_attempts', 'Api\ExamController@get_attempts');
Route::post('/exam/attempt/archive', 'Api\ExamController@get_attempt_archive');
Route::post('/exam/the_best', 'Api\ExamController@the_best');

Route::get('/news/header', 'Api\NewsController@header');
Route::get('/news/all', 'Api\NewsController@all');
Route::post('/news/vote', 'Api\NewsController@vote');

Route::get('/videos/all', 'Api\VideoController@all');
Route::post('/video/watch', 'Api\VideoController@watch');

Route::post('/notifications/get', 'Api\AuthController@notifications');

Route::post('/contact_us', 'Api\SettingController@contact_us');

Route::get('/get_categories', 'Api\DropController@get_categories');
Route::get('/get_cities', 'Api\DropController@get_cities');
Route::get('/get_educations', 'Api\DropController@get_educations');

Route::get('/get_settings', 'Api\HomeController@get_settings');


Route::post('/paypal/request', 'Api\PaypalController@request');
Route::get('/payment/{status}', 'Api\PaypalController@fallback');

Route::post('/delete_request', 'Api\AuthController@delete_request');

Route::get('/push_notify/{user_id}', 'Api\AuthController@push_notify');
