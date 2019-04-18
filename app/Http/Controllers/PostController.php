<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {	
        return view('posts.show', compact('post'));
    }


    public function create()
    {	
        $this->authorize('create', Post::class);
    }


    public function store(Request $request, Post $post)
    {   
        $this->authorize('create', Post::class);
        $attributes = $this->validateRequest(request());
        $post->createPost($attributes);
        toast('Comment saved','success','top-right');

        return redirect($post->path());
    }

    public function update(Post $post)
    {
        $this->authorize('manage', $post);
        $post->update( $this->validateRequest(request()));
        toast('Post updated','success','top-right');
        return redirect($post->path());
    }

    public function destroy(Post $post)
    {
        $this->authorize('create', Post::class);
        $this->authorize('manage', $post);
        $post->delete();
        toast('Comment destroyed','success','top-right');

        return redirect('/posts');
    }

    private function validateRequest($request)
    {
        return $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
    }
}
