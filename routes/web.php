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

Route::get('/', function () {
    return view('main');
})->middleware('auth')->name('home');

Route::get('/logout', function () {
    Auth::logout();
    return view('auth.login');
})->name('_logout');

Route::post('/_login', 'LoginController@authenticate')->name('_login');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//xác thực người dùng
Route::get('/approve', 'SuperAdminController@approve')->middleware('auth')->name('approve');
Route::post('/accept/{id}', 'SuperAdminController@accept')->name('accept');
Route::post('/deny/{id}', 'SuperAdminController@deny')->name('deny');

//tìm kiếm từ khóa
Route::get('/keyword', 'UserController@keyword')->middleware('auth')->name('keyword');
Route::post('/find_keyword', 'UserController@findkeyword')->name('findkeyword');

Route::post('/chart', 'UserController@chart')->name('chart');
Route::post('/classify', 'UserController@classify')->name('classify');

//xem thông tin bài báo
Route::get('/article_info', 'UserController@article_info')->middleware('auth')->name('articles_info');
Route::get('/article_info/{id}', 'UserController@article_info')->middleware('auth')->name('article_info');

//thông tin cá nhân
Route::get('/info/{id?}', 'UserController@info')->middleware('auth')->name('info');
Route::post('/update_info', 'UserController@update')->middleware('auth')->name('update_info');

//quản lý người dùng
Route::get('/manage', 'SuperAdminController@manage')->middleware('auth')->name('manage');
Route::post('/update/{id}', 'SuperAdminController@update')->name('update');
Route::post('/delete/{id}', 'SuperAdminController@delete')->name('delete');

//Lịch sử sử dụng
Route::get('/diary', 'SuperAdminController@diary')->middleware('auth')->name('diary');

//Tóm tắt
Route::get('/summary', 'UserController@summary_show')->middleware('auth')->name('summary_show');
Route::post('/summary', 'UserController@summary')->middleware('auth')->name('summary');

Route::get('/hot', 'UserController@getHotTopic');