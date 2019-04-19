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

Route::get('admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.showLoginForm');
Route::post('admin/login', 'Admin\Auth\LoginController@login')->name('admin.login');

/**ADMIN  ROUTES */
Route::group(['middleware' => ['onlyAdmin']], function() {
        Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
                Route::get('/', 'AdminController@index')->name('dashboard');
        });
});

/** END ADMLIN ROURES */

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
