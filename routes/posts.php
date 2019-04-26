<?php

/** POST ROUTES */
Route::resource('posts', 'PostController');

Route::prefix('manage')->name('manage.')->group(function () {
        Route::get('posts', 'PostController@managePosts')
                ->name('posts')->middleware('activated','can:create,App\Post '); 
});

Route::group(['middleware' => ['activated']], function() {
        
        /** POST COMMENTS ROUTES */
        Route::post('/posts/{post}/comments', 'PostCommentsController@store')
                ->name('posts.comments.store');

        Route::patch('/comments/{comment}', 'PostCommentsController@update')
                ->name('posts.comments.update');

        Route::delete('/comments/{comment}', 'PostCommentsController@destroy')
                ->name('posts.comments.destroy');
/** END POST COMMENTS ROUTE */
});
/** END POST ROUTES */



?>