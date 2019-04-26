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
        return redirect($post->path())->with('success', 'Post saved');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Post $post)
    {
        $this->authorize('update', $post);
        $post->update($this->validateRequest(request()));
        return redirect($post->path())->with('success', 'post updated');
    }

    public function destroy(Post $post)
    { 
        $this->authorize('delete', $post);
        $post->delete();
        return redirect(route('manage.posts'))->with('success', 'post deleted');;
    }

    public function managePosts()
    {
        $this->authorize('create', Post::class);
        $posts = auth()->user()->posts; 
        return view('posts.managePosts', compact('posts'));
    }

    private function validateRequest($request)
    {
        return $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
    }
}
