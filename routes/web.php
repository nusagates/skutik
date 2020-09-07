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
Route::get('/notify/comment', 'NotificationController@comment')->name('notif.comment');
Route::resource('post', 'PostController')->except('show');
Route::get('/post/{post_slug}', 'PostController@show')->name('post.show');
Route::get('/post/tagged/{tag_slug}', 'PostController@tag')->name('post.tag');
Route::get('/author/{username}', 'PostController@author')->name('author');
Route::resource('post.comment', 'CommentController')->except(['index', 'show', 'create']);
Route::group(['prefix' => 'media'], function () {
    Route::post('image/upload', 'MediaController@image_upload')->name('media.image.upload');
    Route::get('image/', 'MediaController@image')->name('media.image');
    Route::get('image/', 'MediaController@image')->name('media.image');
    Route::get('image/{filename}', 'MediaController@image')->name('media.image');
});
