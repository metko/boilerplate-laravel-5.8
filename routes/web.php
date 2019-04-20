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

/**USERS ROUTES */
Route::group(['middleware' => ['auth']], function() {
        Route::get('profil', 'UsersController@index')->name('profil.index');
        Route::delete('profil', 'UsersController@destroy')->name('profil.destroy');
        Route::patch('profil/update', 'UsersController@update')->name('profil.update');
        Route::patch('profil/updatePassword', 'UsersController@updatePassword')->name('profil.update.password');
        Route::get('profil/updatePassword', 'UsersController@updatePassword')->name('profil.edit.password');
});
/**END USER ROUTES */

/**ADMIN  ROUTES */
Route::get('admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.showLoginForm');
Route::post('admin/login', 'Admin\Auth\LoginController@login')->name('admin.login');

Route::group(['middleware' => ['onlyAdmin']], function() {
        Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {

                Route::get('/', 'AdminController@index')->name('dashboard');

                Route::patch('users/{user}', 'UsersController@update')->name('users.update');
                Route::patch('users/password/{user}', 'UsersController@updatePassword')->name('users.update.password');
                Route::delete('users/{user}', 'UsersController@destroy')->name('users.destroy');

        });
});
/** END ADMLIN ROURES */

/** POST ROUTES */
Route::resource('posts', 'PostController');
Route::group(['middleware' => ['can:create,App\Post']], function() {
        Route::prefix('manage')->name('manage.')->group(function () {
                Route::get('posts', 'PostController@managePosts')->name('posts');
        });
});
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
