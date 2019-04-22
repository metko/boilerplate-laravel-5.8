<?php

/**ADMIN  ROUTES */
Route::get('admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.showLoginForm');
Route::post('admin/login', 'Admin\Auth\LoginController@login')->name('admin.login');

Route::group(['middleware' => ['onlyAdmin','verified', 'activated']], function() {
        Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {

                Route::get('/', 'AdminController@index')->name('dashboard');
                Route::patch('users/{user}', 'UsersController@update')->name('users.update');
                Route::patch('users/password/{user}', 'UsersController@updatePassword')->name('users.update.password');
                
                Route::post('users/desactivate/{user}', 'UsersController@desactivate')->name('users.desactivate');
               
                Route::delete('users/{user}', 'UsersController@destroy')->name('users.destroy');
        });
});
/** END ADMLIN ROURES */

?>