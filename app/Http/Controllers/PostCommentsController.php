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
        toast('Comment saved','success','top-right');

        return redirect($post->path());
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
        $this->authorize('manage', $comment);
        $attributes = $this->validateRequest($request);
        $comment->update($attributes);
        toast('Comment updated','success','top-right');

        return redirect($comment->post->path());
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
        $this->authorize('manage', $comment);
        $comment->delete();
        toast('Comment destroyed','success','top-right');
        return redirect($comment->post->path());
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
