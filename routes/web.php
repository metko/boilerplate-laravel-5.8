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

Route::get('/posts/create', 'PostController@create');
Route::get('/posts/{post}', 'PostController@show');
Route::delete('/posts/{post}', 'PostController@destroy');
Route::patch('/posts/{post}', 'PostController@update');
Route::post('/posts', 'PostController@store');

Route::post('/posts/{post}/comments', 'PostCommentsController@store')->middleware('auth');
Route::patch('/comments/{comment}', 'PostCommentsController@update')->middleware('auth');
Route::delete('/comments/{comment}', 'PostCommentsController@destroy')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
