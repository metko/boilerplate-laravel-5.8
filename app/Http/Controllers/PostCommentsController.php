<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PostCommentsController extends Controller
{
    /**
     * store
     *
     * @param  mixed $request
     * @param  mixed $post
     *
     * @return void
     */
    public function store(Request $request, Post $post)
    {
        $attributes = $this->validateRequest($request);
        $comment = $post->addComment($attributes);
        return redirect($post->path())->with('success', 'post stored');
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $comment
     *
     * @return void
     */
    public function update(Request $request, Comment $comment)
    {   
        $this->authorize('update', $comment);
        $attributes = $this->validateRequest($request);
        $comment->update($attributes);
        return redirect($comment->post->path())->with('success', 'post updated');
    }

    /**
     * destroy
     *
     * @param  mixed $request
     * @param  mixed $comment
     *
     * @return void
     */
    public function destroy(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect($comment->post->path())->with('success', 'post deleted');
    }

    /**
     * validateRequest
     *
     * @param  mixed $request
     *
     * @return void
     */
    private function validateRequest(Request $request){
       
        return $request->validate([
            'body' => 'required|min:3',
        ]);
    }
}
