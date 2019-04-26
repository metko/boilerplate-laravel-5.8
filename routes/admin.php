<?php

/**ADMIN  ROUTES */
Route::get('admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.showLoginForm');
Route::post('admin/login', 'Admin\Auth\LoginController@login')->name('admin.login');

Route::group(['middleware' => ['hasRole:admin', 'activated']], function() {
        Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {

                Route::get('/', 'AdminController@index')->name('dashboard');
                Route::get('/users', 'UsersController@index')->name('users.index');
                Route::get('/users/create', 'UsersController@create')->name('users.create');
                Route::get('/users/{user}', 'UsersController@show')->name('users.show');
                Route::get('/users/edit/{user}', 'UsersController@edit')->name('users.edit');

                Route::get('/users/admin/profile', 'UsersAdminController@show')->name('users.admin.show');
                Route::get('/users/admin/edit/{user}', 'UsersAdminController@edit')->name('users.admin.edit');

                Route::patch('users/{user}', 'UsersController@update')->name('users.update');
                Route::patch('users/password/{user}', 'UsersController@updatePassword')->name('users.update.password');
                Route::patch('users/admin/update', 'UsersAdminController@update')->name('users.admin.update');
                
                Route::post('users', 'UsersController@store')->name('users.store');
                Route::post('users/desactivate/{user}', 'UsersController@desactivate')->name('users.desactivate');
               
                Route::delete('users/{user}', 'UsersController@destroy')->name('users.destroy');


                Route::resource('posts', 'PostController');


                Route::get('roles', 'RolesController@index')->name('roles.index');
                Route::get('roles/create', 'RolesController@create')->name('roles.create');
                Route::get('roles/{role}', 'RolesController@show')->name('roles.show');
                
                Route::get('permissions/create', 'PermissionController@create')->name('permissions.create');
                Route::patch('permissions/{role}/update', 'PermissionController@update')->name('permissions.update');
                Route::post('permissions/store', 'PermissionController@store')->name('permissions.store');
        });
});
/** END ADMLIN ROURES */

?>