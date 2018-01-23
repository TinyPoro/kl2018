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

Route::get('/article_info', 'UserController@info')->middleware('auth')->name('articles_info');

Route::get('/article_info/{id}', 'UserController@info')->middleware('auth')->name('article_info');