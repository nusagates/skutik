<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PostController@index')->name('root');

Auth::routes(['verify' => true]);

Route::get('/home', 'PostController@index')->name('home');
Route::resource('post', 'PostController')->except('show');
Route::get('/post/{post_slug}', 'PostController@show')->name('post.show');
Route::get('/post/tagged/{tag_slug}', 'PostController@tag')->name('post.tag');
Route::get('/author/{username}', 'PostController@author')->name('author');
