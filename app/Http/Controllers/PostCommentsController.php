<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $attributes = $this->validateRequest($request);
        $comment = $post->addComment($attributes);
    }


    public function update(Request $request, Comment $comment)
    {   
        $this->authorize('manage', $comment);

        $attributes = $this->validateRequest($request);
        $attributes['owner_id'] = auth()->user()->id;
        
        $comment->update($attributes);
    }

    public function destroy(Request $request, Comment $comment)
    {
        $this->authorize('manage', $comment);
        $post = $comment->post;
        $comment->delete();
        return redirect($post->path());
    }

    private function validateRequest(Request $request){
       
        return $request->validate([
            'body' => 'required|min:3',
        ]);
    }
}
