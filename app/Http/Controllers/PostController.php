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


    public function create(Post $post)
    {	
        $this->authorize('create', Post::class);
        return view('posts.create', compact('post'));
    }


    public function store(Request $request, Post $post)
    {   
        $this->authorize('create', Post::class);
        $attributes = $this->validateRequest(request());
        $post = $post->createPost($attributes);
        toast('Post saved','success','top-right');

        return redirect($post->path());
    }

    public function edit(Post $post)
    {
       
        $this->authorize('manage', $post);
        return view('posts.edit', compact('post'));
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

        return redirect(route('manage.posts'));
    }

    private function validateRequest($request)
    {
        return $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
    }

    public function managePosts()
    {
        $this->authorize('create', Post::class);
        $posts = auth()->user()->posts;
        //dd($posts->all());
        return view('posts.managePosts', compact('posts'));
    }
}
