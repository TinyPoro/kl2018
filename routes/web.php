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
Route::get('/approve', 'SuperAdminController@approve')->name('approve');

Route::post('/accept/{id}', 'SuperAdminController@accept')->name('accept');
Route::post('/deny/{id}', 'SuperAdminController@deny')->name('deny');

//tìm kiếm từ khóa
Route::get('/keyword', 'UserController@keyword')->name('keyword');

Route::post('/findkeyword', 'UserController@findkeyword')->name('findkeyword');