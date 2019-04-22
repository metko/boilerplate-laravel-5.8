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

include(base_path('routes/users.php'));
include(base_path('routes/admin.php'));
include(base_path('routes/posts.php'));



Route::get('/home', 'HomeController@index')->name('home')->middleware('activated');
