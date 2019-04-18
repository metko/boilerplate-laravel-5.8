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
})->name('homepage');

Auth::routes();

/** POST ROUTES */
Route::resource('posts', 'PostController');
/** END POST ROUTES */

/** POST COMMENTS ROUTES */
Route::post('/posts/{post}/comments', 'PostCommentsController@store')
        ->name('posts.comments.store')->middleware('auth');

Route::patch('/comments/{comment}', 'PostCommentsController@update')
        ->name('posts.comments.update')->middleware('auth');

Route::delete('/comments/{comment}', 'PostCommentsController@destroy')
        ->name('posts.comments.destroy')->middleware('auth');
/** END POST COMMENTS ROUTE */

Route::get('/home', 'HomeController@index')->name('home');
