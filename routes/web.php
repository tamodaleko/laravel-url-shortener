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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('{code}', 'UrlController@redirect')->where('code', '[0-9a-zA-Z]{8}');

Route::post('/urls', 'UrlController@store')->name('urls.store');
Route::delete('/urls/{id}', 'UrlController@destroy')->name('urls.destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
