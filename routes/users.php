<?php 
Auth::routes();
Route::get('account/desactivate', 'ActivateController@show')->name('account.activate.notice');

/**USERS ROUTES */
Route::group(['middleware' => ['auth', 'activated']], function() {
        
        Route::get('profile', 'UsersController@index')->name('profile.index');

        Route::post('account/desactivate', 'ActivateController@desactivate')->name('account.desactivate');
        Route::post('profile/avatar/store', 'UsersController@storeAvatar')->name('profile.store.avatar');

        Route::get('profile/edit', 'UsersController@edit')->name('profile.edit');
        Route::get('profile/edit/password', 'UsersController@editPassword')->name('profile.edit.password');

        Route::patch('profile/update', 'UsersController@update')->name('profile.update');
        Route::patch('profile/updateProfile', 'UsersController@updateprofile')->name('profile.updateProfile');
        Route::patch('profile/updatePassword', 'UsersController@updatePassword')->name('profile.update.password');

        Route::delete('profile', 'UsersController@destroy')->name('profile.destroy');
         
});
/**END USER ROUTES */
?>