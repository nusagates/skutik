<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashflowProjectController;

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
/* Social Media Auth*/
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/', 'PostController@index')->name('root');

Auth::routes(['verify' => true]);
Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');
Route::get('/home', 'PostController@index')->name('home');
Route::get('/notify/comment', 'NotificationController@comment')->name('notif.comment');

/* post */
Route::resource('post', 'PostController')->except('show');
Route::get('/post/{post_slug}', 'PostController@show')->name('post.show');
Route::get('/post/tagged/{tag_slug}', 'PostController@tag')->name('post.tag');
Route::get('/author/{username}', 'PostController@author')->name('author');
Route::resource('post.comment', 'CommentController')->except(['index', 'show', 'create']);

/* Challenge */
Route::resource('challenge', 'ChallengeController')->except('show');
Route::resource('challenge.quiz', 'ChallengeQuizController')->except('index');
Route::get('/challenge/{challenge_slug}', 'ChallengeController@show')->name('challenge.show');
Route::get('/challenge/{challenge_slug}/quiz', 'ChallengeQuizController@index')->name('challenge.quiz.index');
Route::post('/challenge/quiz/answer', 'QuizAnswerController@store')->name('quiz.answer');
Route::post('/challenge/{id}/finish', 'ChallengeController@finish')->name('challenge.finish');
Route::get('/challenge/result/{slug}', 'ChallengeController@result')->name('challenge.result');
Route::get('/challenge/result/image/{slug}', 'ChallengeController@result_image')->name('challenge.result.image');

/* todo */
Route::resource('todo', 'TodoController')->except('show');
Route::resource('todo.list', 'TodoListController')->only('store', 'update', 'destroy');
Route::get('/todo/{todo_slug}', 'TodoController@show')->name('todo.show');
Route::post('/todo/list/children' ,'TodoListChildController@store');
Route::post('/todo/list/children/update' ,'TodoListChildController@update');
Route::post('/todo/list/children/remove' ,'TodoListChildController@destroy');

/* media */
Route::group(['prefix' => 'media'], function () {
    Route::post('image/upload', 'MediaController@image_upload')->name('media.image.upload');
    Route::get('image/{filename}', 'MediaController@image')->name('media.image');
});

Route::group(['prefix'=>'cashflow', 'middleware'=>['auth', 'verified']], function (){
    Route::get('/', [CashflowProjectController::class, 'index']);
    Route::resource('project', 'CashflowProjectController')->except(['create']);
});

