<?php

/** POST ROUTES */
Route::resource('posts', 'PostController');
Route::group(['middleware' => ['can:create,App\Post','verified', 'activated']], function() {
        Route::prefix('manage')->name('manage.')->group(function () {
                Route::get('posts', 'PostController@managePosts')->name('posts');
        });
});
/** END POST ROUTES */

/** POST COMMENTS ROUTES */
Route::group(['middleware' => ['auth', 'verified', 'activated']], function() {
        Route::post('/posts/{post}/comments', 'PostCommentsController@store')
                ->name('posts.comments.store');

        Route::patch('/comments/{comment}', 'PostCommentsController@update')
                ->name('posts.comments.update');

        Route::delete('/comments/{comment}', 'PostCommentsController@destroy')
                ->name('posts.comments.destroy');
});

/** END POST COMMENTS ROUTE */

?>